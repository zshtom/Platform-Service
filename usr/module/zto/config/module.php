<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

return array(
    // Module meta
    'meta'  => array(
        // Module title, required
        'title'         => _a('zto'),
        // Description, for admin, optional
        'description'   => _a('zto first Examples.'),
        // Version number, required
        'version'       => '1.1.0',
        // Distribution license, required
        'license'       => 'ztok999'
    
    ),
    // Author information
    'author'    => array(
        // Author full name, required
        'Name'      => 'tao zhang',
        // Email address, optional
        'Email'     => 'zhangtao@social-touch.com'
    ),
    // Module dependency: list of module directory names, optional
    'dependency'    => array(
    ),

    // Resource
    'resource' => array(
        // Database meta
        'database'  => array(
            // SQL schema/data file
            'sqlfile'   => 'sql/mysql.sql',

        ),
        'navigation'    => 'navigation.php',
		'block'  => 'block.php',
		'config'    => 'config.php',
		'page'      => 'page.php',
    ),
);
