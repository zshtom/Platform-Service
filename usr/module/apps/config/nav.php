<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

return array(
    'meta'  => array(
        'site'  => array(
            'title'     => _t('Custom site navigation in Apps module'),
            'section'   => 'front',
        ),
    ),
    'item'  => array(
        'front'     => true,
        'admin'     => array(
            'description' => array(
        	   'label'          => _t('Apps Description'),
               'route'          => 'admin',
               'controller'     => 'index',
               'action'         => 'description',
            ),
            'list'     => array(
                'label'         => _t('Product list'),
                'route'         => 'admin',
                'controller'    => 'index',
                'action'        => 'index',
            ),
            'add'   => array(
                'label'         => _t('Add a app'),
                'route'         => 'admin',
                'controller'    => 'index',
                'action'        => 'add',
            ),
        ),

        // Custom navigation
        'site' => array(
            'modules'   => array(
                'callback'  => array('navigation', 'front'),
            ),
        ),
    ),
);
