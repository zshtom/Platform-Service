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

/**
 * Block class for providing apps nav.
 *
 * @author Ferrch.com <www.ferrch.com>
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
    public static function appsNav($options = array(), $module = null)
    {
        if (empty($module)) {
            return false;
        }

        $list = array();

        $rowset  = Pi::api('api', $module)->getAppsList(1);

        foreach ($rowset as $row) {
            $id = (int) $row['id'];
            $item = array(
                'name'  => $row['name'],
                'title' => $row['title'],
                'icon'  => $config['icon_upload_path'] . '/' . $row['icon'],
                'url'   => Pi::service('url')->assemble(
                                '',
                                array('', 'id' => $row['id'])
                           ),
            );
            $list[$id] = $item;
        }

        return array(
            'items'     => $list,
        );
    }

}
