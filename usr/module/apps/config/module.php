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
        'title'         => _a('Product Module'),
        // Description, for admin, optional
        'description'   => _a('Product module description'),
        // Version number, required
        'version'       => '1.0.2',
        // Distribution license, required
        'license'       => 'New BSD',
        // Logo image, for admin, optional
        'logo'          => 'image/apps-logo.png',
        // Demo site link, optional
        'demo'          => 'http://demo.pialog.org/demo',
        'icon'          => 'fa-file-text-o',
        'clonable'      => false,
    ),
    // Author information
    'author'    => array(
        // Author full name, required
        'Dev'       => 'Ferrch.com',
        // Email address, optional
        'Email'     => 'xiaodenan@ferrch.com',
        // Website link, optional
        'Website'   => 'http://ferrch.com',
        // Credits and acknowledgement, optional
        'Credits'   => 'Ferrch'
    ),

    // Resource
    'resource' => array(
        // Database meta
        'database'  => array(
            // SQL schema/data file
            'sqlfile'   => 'sql/mysql.sql',
        ),
        // Module Config
        'config'        => 'config.php',
        // Routes, first in last out; bigger priority earlier out
        'route'         => 'route.php',
        // Navigation definition
        'navigation'    => 'nav.php',
    ),
);
