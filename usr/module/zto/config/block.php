<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

return array(
    // Block with options and template
    'block-a'   => array(
        'title'         => _a('zto First Block'),
        'description'   => _a('Block with options and tempalte'),
        'render'        => array('block', 'blocka'),
        'template'      => 'block-a',
        'config'        => array(
            // text option
            'first' => array(
                'title'         => _a('Your input'),
                'description'   => _a('The first option for first block'),
                'edit'          => 'text',
                'filter'        => 'string',
                'value'         => _a('Demo option 1'),
            ),
            // Yes or No option
            'second'    => array(
                'title'         => _a('Yes or No'),
                'description'   => _a('Demo for Yes-No'),
                'edit'          => 'checkbox',
                'filter'        => 'int',
                'value'         => 0
            ),
            // Number
            'third'    => array(
                'title'         => _a('Input some figure'),
                'description'   => _a('Demo for number'),
                'edit'          => 'text',
                //'filter'        => 'int',
                'value'         => 10,
            ),
        ),
        'access'        => array(
            'guest'     => 0,
            'member'    => 1,
        ),
    ),
);
