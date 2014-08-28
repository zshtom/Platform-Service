<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

return array(
    'category' => array(
        array(
            'title' => __('Icon Setting'),
            'name' => 'icon'
        ),
    ),
    'item' => array(
        // Social
        'icon_upload_path' => array(
            'category'      => 'icon',
            'title'         => _t('Icon Upload Path'),
            'description'   => '',
            'edit'          => 'input',
            'filter'        => 'text',
            'value'         => 'upload/apps/'
        ),
        'icon_max_size' => array(
            'category'      => 'icon',
            'title'         => _t('Upload file size limit'),
            'description'   => '',
            'edit'          => 'input',
            'filter'        => 'int',
            'value'         => 2048
        ),
        'icon_max_width' => array(
            'category'      => 'icon',
            'title'         => _t('Upload picture width limit'),
            'description'   => '',
            'edit'          => 'input',
            'filter'        => 'int',
            'value'         => 80
        ),
        'icon_max_height' => array(
            'category'      => 'icon',
            'title'         => _t('Upload picture height limit'),
            'description'   => '',
            'edit'          => 'input',
            'filter'        => 'int',
            'value'         => 80
        ),
        'icon_media' => array(
            'category'      => 'icon',
            'title'         => _t('Upload files types'),
            'description'   => '',
            'edit'          => 'textarea',
            'filter'        => 'text',
            'value'         => 'jpg, jpeg, png, gif'
        ),
    ),
);