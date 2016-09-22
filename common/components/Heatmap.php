<?php
/**
 * Created by PhpStorm.
 * User: heale
 * Date: 2016/9/22
 * Time: 21:22
 */

namespace common\components;


class Heatmap
{
    public static function refresh($deviceDataItems)
    {
        $b = false;
        $ps = [0];
        foreach ($deviceDataItems as $a)
        {
            if (!$b) {
                $b = $a;
                continue;
            }

            $p = pow(($a['lng'] - $b['lng']), 2) + pow(($a['lat'] - $b['lat']), 2) * 10000;
            $ps[] = $p;

        }

        $avg = self::avg($ps);

        $index = 0;
        $dist = 0;
        $points = [];
        $section = [];

        foreach ($deviceDataItems as $i)
        {
            $section[] = $i;
            $dist += $ps[$index];

            if ($dist >= $avg)
            {
                $points = array_merge($points, self::leverage($section));

                $dist = 0;
                $section = [];
            }

            $index++;

        }
        $points = array_merge($points, self::leverage($section));

        return $points;
    }

    private static function leverage($section)
    {
        foreach ($section as &$i)
        {
            $i['inner_doserate'] = $i['inner_doserate'] / count($section) / count($section) / 20;
        }
        return $section;
    }

    private static function avg($p)
    {
        $sum = 0;
        foreach ($p as $i)
        {
            $sum += $i;
        }
        return $sum / count($p);
    }
}