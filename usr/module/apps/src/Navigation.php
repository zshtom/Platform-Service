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
    public static function modules($module)
    {
        $nav = array(
            'apps'     => array(),
        );

        $modules = Pi::registry('modulelist')->read('active');
        unset($modules['system']);
        foreach ($modules as $key => $data) {
            $nav['apps'][$key] = array(
                'label'     => $data['title'],
                'module'    => $key,
                'route'     => 'admin',
            );
        }

        return $nav;
    }
}
