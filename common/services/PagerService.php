<?php
/**
 * NucDcenter
 * User: healer_kx@163.com
 * DateTime: 2016/9/4 16:37
 *
 */

namespace common\services;


class PagerService
{

    public static function getPager($count, $current)
    {
        $pagers = [];
        if ($count <= 10) {
            $pagers = array_merge($pagers, self::getPagerRange(1, $count, $current));
        } else {
            $pagers = array_merge($pagers, self::getPagerRange(1, 5, $current));
            $pagers[] = ['type' => 'input'];
            $pagers = array_merge($pagers, self::getPagerRange($count - 4, $count, $current));
        }

        return $pagers;
    }

    private static function getPagerRange($from, $to, $current)
    {
        $ret = [];
        for ($i = $from; $i <= $to; $i++)
        {
            $active = $i == $current;
            $ret[] = ['type' => 'pager', 'title' => $i, 'active' => $active];
        }
        return $ret;
    }
}