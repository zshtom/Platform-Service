<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Apps;

use Pi;

class Navigation
{
    public static function apps($module)
    {
        $nav = array(
            'pages' => array(),
        );

        // Get the nav from list because active not set in registry.
        try {
            $apps_list  = Pi::api('api', $module)->getAppsList(1);
        } catch (\Exception $exception) {
            return '';
        }

        d($apps_list);

//         $apps_list = Pi::registry($module, $module)->read();

        foreach ($apps_list as $key => $data) {
            $nav['pages'][$key] = array(
                'label'     => $data['title'],
                'module'    => 'apps',
                'uri'     => $data['url'],
            );
        }

        d($nav);

        return $nav;

    }

    /**
     * @TODO Move it to solution module?
     * solutionList()
     *   - Try get solution list for nav from solution module.
     *
     * @param string $module
     *   - Current module name.
     *
     * @return array
     *   - <multitype:multitype: , multitype:string unknown >
     */
    public static function solutions($module)
    {
        $nav = array(
            'pages' => array(),
        );

        $nav_list = array();

        // Get the nav from list because active not set in registry.
        try {
//             $nav_list  = Pi::api('api')->solution->getSolutionList();
            $nav_list = Pi::api('api', 'solution')->getSolutionList(1);
        } catch (\Exception $exception) {
            return false;
        }

        d($nav_list);

        foreach ($nav_list as $key => $data) {
            $nav['pages'][$key] = array(
                'label'     => $data['title'],
                'module'    => 'apps',
                'uri'     => $data['url'],
            );
        }

        d($nav);

        return $nav;
    }
}
