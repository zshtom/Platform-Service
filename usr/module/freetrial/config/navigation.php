<?php
/**
 * Pi Engine (http://www.social-touch.com/)
 *
 * @link      http://www.social-touch.com/ for the Pi Engine source repository
 * @copyright Copyright (c) Pi Engine (http://www.social-touch.com/)
 */
return array(
    'item'    => array(
        'admin'   => array(
            'pagea'   => array(
                'label'      => __('List Member'),
                'route'      => 'admin',
                'controller' => 'index',
                'action'     => 'index',
            )
	    'pageb'   => array(
                'label'      => __('Export List'),
                'route'      => 'admin',
                'controller' => 'export',
                'action'     => 'index',
            ),
        ),
    ),
);