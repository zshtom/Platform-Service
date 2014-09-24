<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

return array(
    // Categories for config edit or display
    'category'  => array(
        array(
            'title' => _t('ContactUsForm'),
            'name'  => 'contactForm',
        ),
        array()
    ),
    // Config items
    'item'  => array(
        'company' => array(
            'category'      => 'contactForm',
            'title'         => _t('company'),
            'description'   => _t('公司名称'),
            'edit'          => 'checkbox',
            'value'         => 1,
            'filter'        => 'int',
        ),
        'phone' => array(
            'category'      => 'contactForm',
            'title'         => _t('phone'),
            'description'   => _t('联系方式'),
            'edit'          => 'checkbox',
            'value'         => 0,
            'filter'        => 'int',
        ),
        'email' => array(
            'category'      => 'contactForm',
            'title'         => _t('email'),
            'description'   => _t('Email'),
            'edit'          => 'checkbox',
            'value'         => 0,
            'filter'        => 'int',
        ),
        'address' => array(
            'category'      => 'contactForm',
            'title'         => _t('address'),
            'description'   => _t('地址'),
            'edit'          => 'checkbox',
            'value'         => 0,
            'filter'        => 'int',
        )
    )
);
