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
            'apps' => array(),
        );

        d($module);

        // Get the nav from list because active not set in registry.
        $apps_list  = Pi::api('api', $module)->getAppsList(1);

//         $apps_list = Pi::registry($module, $module)->read();

        foreach ($apps_list as $key => $data) {
            $nav['pages'][$key] = array(
                'label'     => $data['title'],
                'module'    => 'apps',
                'uri'     => '/' . $module . '/' . $data['name'],
            );
        }



        return $nav;
    }
}
