<?php
/**
 * Pi Engine (http://www.social-touch.com/)
 *
 * @link      http://www.social-touch.com/ for the Pi Engine source repository
 * @copyright Copyright (c) Pi Engine (http://www.social-touch.com/)
 */
return array(
    // Module meta
    // 'acl'       =>'acl.php',
    'meta'  => array(
        // Module title, required
        'title'         => _a('Freetrial'),
        // Description, for admin, optional
        'description'   => _a('Freetrial'),
        // Version number, required
        'version'       => '1.1.0',
        // Distribution license, required
        'license'       => 'New BSD',
        // Logo image, for admin, optional
        'logo'          => 'asset/image/logo.jpg',
        // Readme file, for admin, optional
        'readme'        => 'docs/readme.txt',
        // Demo site link, optional
        'demo'          => 'http://demo.pialog.org/demo',
        // Logo icon
        'icon'          => 'fa-code',

        // Module is ready for clone? Default as false
        'clonable'      => true,
    ),
    // Author information
    'author'    => array(
        // Author full name, required
        'Name'      => 'Shixin Song',
        // Email address, optional
        'Email'     => 'songshixin@social-touch.com',
        // Website link, optional
        'Website'   => 'http://pialog.org',
        // Credits and aknowledgement, optional
        'Credits'   => 'Pi Engine Team'
    ),
    // Module dependency: list of module directory names, optional
    'dependency'    => array(
    ),

    'resource' => array(


        'database'  => array(
            // SQL schema/data file
            'sqlfile'   => 'sql/mysql.sql',
        ),
        // Module configs
        'config'    => 'config.php',
        // Permission specs
        'permission'    => 'permission.php',
        // Block definition
        'block'     => 'block.php',
        // Bootstrap, priority
        'bootstrap' => 1,
        // Event specs
        //'search'    => array('callback' =>
        'event'     => 'event.php',
        // Search registry, 'class:method'array('search', 'index')),
        // View pages
        'page'      => 'page.php',
        // Navigation definition
        'navigation'    => 'navigation.php',
        // Routes, first in last out; bigger priority earlier out
        'route'     => 'route.php',
        // Callback for stats and monitoring
        'monitor'   => array('callback' => array('monitor', 'index')),
        // Additional custom extension
        'test'      => array(
            'config'    => 'For test',
        ),
    ),
);