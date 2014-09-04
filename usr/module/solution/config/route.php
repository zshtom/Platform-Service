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
    'solution'  => array(
        'name'      => 'solution',
        'section'   => 'front',
        'priority'  => 10,

        'type'      => 'Module\Solution\Route\Solution',
        'options'   => array(
            'defaults'  => array(
                'module'        => 'solution',
                'controller'    => 'index',
                'action'        => 'index'
            )
        ),
    )
);
