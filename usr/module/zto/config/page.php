<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

return array(
    // Front section
    'front' => array(
         array(
             'title'      => __('contact page'),
             'controller' => 'form',
             'action'     => 'contact-us',
             'block'      => 1,
             'cache_ttl'     => 300000,
             'cache_level'   => 'locale',
         ),
     ),
);
