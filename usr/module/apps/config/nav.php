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
            'title'     => _t('Custom site navigation'),
            'section'   => 'front',
        ),
    ),
    'item'  => array(
        'front'     => false,
        'admin'     => array(
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

    ),
);
