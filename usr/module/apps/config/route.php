<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

return array(
    // route name
    'apps'  => array(
        'name'      => 'apps',
        'section'   => 'front',
        'priority'  => 10,

        'type'      => 'Module\Apps\Route\Apps',
        'options'   => array(
            'defaults'  => array(
                'module'        => 'apps',
                'controller'    => 'index',
                'action'        => 'index'
            )
        ),
    )
);
