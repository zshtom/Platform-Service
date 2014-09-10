<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link         http://code.pialog.org for the Pi Engine source repository
 * @copyright    Copyright (c) Pi Engine http://pialog.org
 * @license      http://pialog.org/license.txt BSD 3-Clause License
 */
return array(
    'apps_nav'    => array(
        'name'          => 'apps_nav',
        'title'         => _b('Apps Nav List'),
        'description'   => _b('Apps nav list on app page.'),
        'render'        => array('block', 'appsNav'),
        'template'      => 'apps-nav',
    ),
);