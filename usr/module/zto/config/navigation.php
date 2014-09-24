<?php

return array(
    //'translate' => 'navigation',
    'front'   => array(
        'pages'     => array(
            'label'         => _a('添加联系我们'),
            'route'         => 'default',
            'controller'    => 'form',
            'action'        => 'contact-us',
            //'visible'    => 0,
        )
    ),
    'admin' => array(
        array(
            'label'         => _t('contact_us_list'),
            'route'         => 'admin',
            'controller'    => 'contact',
            'action'        => 'list'
        ) 
    ),
);
