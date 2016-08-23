<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/23
 * Time: 0:02
 */

namespace common\services;


class SidebarService
{
    /**
     * @param $title
     * @param $content  string|array
     * @param $params array
     *      selected
     *      badge
     * @return array
     */
    public static function getMenuItem($title, $content, $params=[])
    {
        $menuItem = ['title' => $title];
        if (is_array($content))
        {
            $menuItem['subMenus'] = $content;
        }
        elseif (is_string($content))
        {
            $menuItem['href'] = $content;
        }

        if (is_array($params))
        {
            if (array_key_exists('selected', $params) && $params['selected'])
            {
                $menuItem['selected'] = true;
            }

            if (array_key_exists('badge', $params) && $params['badge'])
            {
                $menuItem['badge'] = $params['badge'];
            }
        }

        return $menuItem;
    }
}