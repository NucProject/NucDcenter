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
    /**
     * @param $count
     * @param $current
     * @return array(
     *      items => data items
     *      count => page count
     *      current => the current page num
     * )
     */
    public static function getPager($count, $current)
    {
        $items = [];
        if ($count <= 10) {
            $items = array_merge($items, self::getPagerRange(1, $count, $current));
        } else {
            $items = array_merge($items, self::getPagerRange(1, 5, $current));
            $items[] = ['type' => 'input'];
            $items = array_merge($items, self::getPagerRange($count - 4, $count, $current));
        }

        return ['items'=> $items, 'count' => $count, 'current' => $current];
    }

    /**
     * @param $from
     * @param $to
     * @param $current int
     * @return array
     */
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