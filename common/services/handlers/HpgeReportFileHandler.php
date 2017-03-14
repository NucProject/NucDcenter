<?php

namespace common\services\handlers;
use common\models\UkDeviceData;
use common\services\DataCenterService;
use common\services\DeviceDataService;
use common\services\EntityIdService;

/**
 * Created by PhpStorm.
 * User: healer
 * Date: 2017/2/13
 * Time: 22:16
 */
class HpgeReportFileHandler extends FileHandler
{
    private $fileName = false;

    private $deviceKey = false;

    public function __construct()
    {

    }

    /**
     * @param \yii\web\UploadedFile $file
     * 上传文件的时候调用这个函数
     *
     * @return boolean
     */
    public function save($file)
    {
        $this->fileName = $file->name;

        $centerId = DataCenterService::deployedCenterId();
        $deviceSn = \Yii::$app->request->get('deviceSn', \Yii::$app->params['defaultHpgeDeviceSnForCurrentDeployedCenter']);
        $this->deviceKey = EntityIdService::genDeviceKey($centerId, $deviceSn);
        $station = 1;
        $sid = \Yii::$app->request->get('folder');

        // Save to dest path
        $destPath = "$station/hpge/$sid/";
        $destFilePath = FileHandler::checkPath($destPath);
        if (!$destFilePath) {
            return false;
        }

        $fileName = $destFilePath . $this->fileName;
        $file->saveAs($fileName);

        $param = \Yii::$app->request->get('param');
        $params = explode(',', $param);

        if (count($params) > 3 && $params[3] == 'RPT')
        {
            $station = 1;
            $time = $params[2];
            $sid = \Yii::$app->request->get('folder');
            $this->recordHpgeReport($fileName, $station, $time, $sid);
        }

        return true;
    }

    public function recordHpgeReport($filePath, $station, $time, $sid)
    {
        $flow = self::getFlowBySid($sid, $station);
        if (!$flow)
            $flow = 1.0;

        $results = $this->parseRptLines($filePath);

        foreach($results as $item)
        {
            $data = [
                'nuclide' => $item[0],
                'activity' => floatval($item[1]),
                'flow' => $flow,
                'activity_concentration' => floatval($item[1]) / $flow
            ];

            DeviceDataService::addEntry($this->deviceKey, $time, ['data' => $data]);
        }
    }

    public function read($fileName)
    {
        $a = @file_get_contents($fileName);
        if (!$a)
            return "No contents";

        $lines = explode("\n", $a);
        $content = array();
        foreach ($lines as $line)
        {
            array_push($content, $line);
        }
        unset($line);
        return $content;
    }

    public function parseRptLines($filePath)
    {
        $lines = $this->read($filePath);

        $resultFileName = dirname($filePath) . '/parse_results.log';

        file_put_contents($resultFileName, "FILE:$filePath lines read\r\n", FILE_APPEND);

        $start1 = false;
        $start2 = false;
        $counter = 0;
        $results = array();
        foreach($lines as $line) {
            $counter++;
            $line = trim($line);
            if (strstr($line, 'S U M M A R Y   O F   N U C L I D E S   I N   S A M P L E') ) {
                $start1 = true;
                continue;
            }

            if ($start1) {
                if (strstr($line, '__________') ) {
                    $start2 = true;
                    continue;
                }
            }

            if ($start2) {
                if (strstr($line, 'S U M M A R Y') )
                    break;

                if ($line == '')
                    continue;
                if (strlen($line) < 5)
                    continue;
                if (strstr($line, 'sample') )
                    continue;
                if (strstr($line, 'ORTEC') )
                    continue;
                $line = str_replace('#', '', $line);    #带有#的支持
                $a = preg_split("/[\\s]+/", $line);

                if (count($a) == 4) {
                    if (is_numeric($a[1]) && is_numeric($a[2]) && is_numeric($a[3])) {
                        array_push($results, array($a[0], $a[1]));
                    }
                }
            }
        }

        // DUMP results into a txt file
        file_put_contents($resultFileName, json_encode($results), FILE_APPEND);
        return $results;
    }

    public static function getFlowBySid($sid, $station)
    {
        return 1.0;
    }
}