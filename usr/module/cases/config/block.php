<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link         http://code.pialog.org for the Pi Engine source repository
 * @copyright    Copyright (c) Pi Engine http://pialog.org
 * @license      http://pialog.org/license.txt BSD 3-Clause License
 */

/**
 * Block config
 * 
 * @author chenxiaoliang <chenxiaoliang@social-touch.com>
 */
return array(
    'category-list'            => array(
        'title'       => _t('Case List'),
        'description' => _t('Listing all case'),
        'render'      => 'block::caseList',
        'template'    => 'case-list',
        'config'      => array(
            'list-count'       => array(
                'title'        => _a('List Count'),
                'description'  => _a('The max categories to display'),
                'filter'       => 'int',
                'value'        => 20,
            ),
            'target'           => array(
                'title'        => _a('Target'),
                'description'  => _a('Open url in which window'),
                'edit'         => array(
                    'type'        => 'select',
                    'attributes'  => array(
                        'options'    => array(
                            '_blank'    => 'Blank',
                            '_parent'   => 'Parent',
                            '_self'     => 'Self',
                            '_top'      => 'Top',
                        ),
                    ),
                ),
                'filter'        => 'string',
                'value'         => '_blank',
            ),
        ),
    ),
);
