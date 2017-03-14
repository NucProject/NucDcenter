<?php
/**
 * Created by PhpStorm.
 * User: heale
 * Date: 2017/2/20
 * Time: 20:50
 */

namespace common\services;

/**
 * Class CinderellaService
 * @package common\services
 * 对于单一的数据中心, 只有一个CinderellaSum表，便于简单维护
 */
class CinderellaService
{
    /**
     * cinderellaSummary
     */
    public static function getSummary($stationId, $start, $end)
    {

        $data = CinderellaSum::find(array("station=$stationId and endtime > '$start' and endtime < '$end'"));
        $ret = array();
        foreach ($data as $item)
        {
            array_push($ret, $item);
        }
        return parent::result(array('items' => $ret));
    }

    // cinderella统计数据（网页）
    /**
     * @param $stationId
     * @param $sid
     */
    private static function makeSummary($stationId, $sid)
    {
        $data = CinderellaData::find(array("station=$stationId and Sid='$sid'"));
        $count = count($data);
        if ($count == 0)
            return;

        $f = $data[0];
        $begin = ApiController::parseTime2($f->BeginTime);
        $workTime = $f->WorkTime;
        $barcode = $f->barcode;
        $flow = 0.0;
        $flowPerHour = 0.0;
        $pressure = 0.0;
        $end = 0;

        foreach ($data as $item)
        {
            $cb = ApiController::parseTime2($item->time);

            if ($cb > $end) {
                $end = $cb;
            }

            if ($item->WorkTime > $workTime) {
                $workTime = $item->WorkTime;
            }

            if ($item->Flow > $flow)
                $flow = $item->Flow;
            $flowPerHour += $item->FlowPerHour;
            $pressure += $item->Pressure;
        }

        $s = CinderellaSum::findFirst("sid ='$sid' and station =$stationId");
        if (!$s)
        {
            $s = new CinderellaSum();
            $s->sid = $sid;
            $s->station = $stationId;
        }

        $s->begintime = date('Y-m-d H:i:s', $begin);
        $s->endtime = date('Y-m-d H:i:s', $end);
        $s->barcode = $barcode;
        $s->flow = $flow;

        $s->pressure = 0;
        $s->flowPerHour = $flow / ((strtotime($workTime, 0) + 8 * 3600) / 3600);
        $s->worktime = $workTime;
        // echo ((strtotime($worktime, 0) + 8 * 3600));

        return $s->save();
    }
}