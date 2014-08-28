<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * Pi Engine host specifications
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 * @author          Taiwen Jiang <taiwenjiang@tsinghua.org.cn>
 */

/**
 * Host definition file
 *
 * Paths/URLs to system folders
 *
 * - URIs without a leading slash are considered relative
 *      to the current Pi Engine host location
 * - URIs with a leading slash are considered semi-relative
 *      requires proper rewriting rules in server conf
 */
return array(
    // URIs to resources
    // If URI is a relative one then www root URI will be prepended
    'uri'       => array(
        // WWW root URI
        'www'       => 'http://localhost/Platform-Service/www',
        // URI to access uploads directory
        'upload'    => 'http://localhost/Platform-Service/www/upload',
        // URI to access static files directory
        'static'    => 'http://localhost/Platform-Service/www/static',
    ),

    // Paths to resources
    // If path is a relative one then www root path will be prepended
    'path'      => array(
        // Sharable paths
        // WWW root path, dependent sub folders: `script`, `public`
        'www'       => 'D:/wamp/www/Platform-Service/www',
        // Library directory
        'lib'       => 'D:/wamp/www/Platform-Service/lib',
        // User extension directory
        'usr'       => 'D:/wamp/www/Platform-Service/usr',
        // Application module directory
        'module'    => 'D:/wamp/www/Platform-Service/usr/module',
        // Theme directory
        'theme'     => 'D:/wamp/www/Platform-Service/usr/theme',
        // Path to static files directory
        'static'    => 'D:/wamp/www/Platform-Service/www/static',
        // Path to vendor library directory: default as `lib/vendor`
        'vendor'    => 'D:/wamp/www/Platform-Service/lib/vendor',
        // Path to module custom directory: default as `usr/custom`
        'custom'    => 'D:/wamp/www/Platform-Service/usr/custom',

        // Application specific paths
        // Path to uploads directory
        'upload'    => 'D:/wamp/www/Platform-Service/www/upload',
        // User data directory
        'var'       => 'D:/wamp/www/Platform-Service/var',

        // Sub-paths of var
        // Path to global collective configuration directory
        'config'    => 'D:/wamp/www/Platform-Service/var/config',
        // Path to cache files directory
        'cache'     => 'D:/wamp/www/Platform-Service/var/cache',
        // Path to logs directory
        'log'       => 'D:/wamp/www/Platform-Service/var/log',
    ),

    // Paths dependent on upper paths
    'directory' => array(
        'asset'     => array(
            'parent'    => 'www',
            'folder'    => 'asset',
        ),
    ),
);
