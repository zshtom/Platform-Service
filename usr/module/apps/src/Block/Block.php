<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link         http://code.pialog.org for the Pi Engine source repository
 * @copyright    Copyright (c) Pi Engine http://pialog.org
 * @license      http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Apps\Block;

use Pi;
use Module\Apps\Apps;
use Zend\Db\Sql\Expression;

use Module\Apps\AppsList;

/**
 * Block class for providing article blocks
 *
 * @author Zongshu Lin <lin40553024@163.com>
 */
class Block
{
    /**
     * List all categories and its children
     *
     * @param array   $options  Block parameters
     * @param string  $module   Module name
     * @return boolean
     */
    public static function appsList($options = array(), $module = null)
    {
        if (empty($module)) {
            return false;
        }

        $route = 'apps';
        $list = array();

//         print('module = <pre>' . $module . '</pre>');
//         print('Api = <pre>' . print_r(Pi::api('api', $module), TRUE) . '</pre>');

        $rowset  = Pi::api('api', $module)->appsList(1);

        foreach ($rowset as $row) {
//             print('Get row id: <pre>' . print_r($row['id']) . '</pre>');
            $id = (int) $row['id'];
            $item = array(
                'name'  => $row['name'],
                'title' => $row['title'],
                'icon'  => $config['icon_upload_path'] . '/' . $row['icon'],
                'url'   => Pi::service('url')->assemble(
                                'apps',
                                array('apps', 'id' => $row['id'])
                           ),
            );
            $list[$id] = $item;
        }

        return array(
            'items'     => $list,
        );
    }

}
