<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Solution;

use Pi;

class Navigation
{

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
            $nav_list  = Pi::api('api', 'solution')->getSolutionList();
        } catch (\Exception $exception) {
            return false;
        }

        foreach ($nav_list as $key => $data) {
            $nav['pages'][$key] = array(
                'label'     => $data['title'],
                'module'    => 'solution',
                'uri'     => '/' . $module . '/' . $data['name'],
            );
        }

        return $nav;
    }

}
