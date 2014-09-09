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
    'meta'  => [
        // Module title, required
        'title'         => _a('Cases'),
        // Description, for admin, optional
        'description'   => _a('Cases'),
        // Version number, required
        'version'       => '0.1',
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
        'clonable'      => false,
    ],
    // Author information
    'author'    => array(
        // Author full name, required
        'Name'      => 'Chenxiaoliang',
        // Email address, optional
        'Email'     => 'chenxiaoliang@social-touch.com',
        // Website link, optional
        'Website'   => 'http://www.social-touch.com',
        // Credits and aknowledgement, optional
        'Credits'   => 'Pi Engine Team'
    ),
    // Module dependency: list of module directory names, optional
    'dependency'    => array(
    ),

    'resource' => array(
        // Module Config
        'config'        => 'config.php',
        'block'         => 'block.php',
        // Database meta
        'database'  => array(
            // SQL schema/data file
            'sqlfile'   => 'sql/mysql.sql',
        ),
        // Navigation definition
        'navigation'    => 'nav.php',
    ),
);