<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Apps\AppsList;

use Pi;
use Pi\Application\Api\AbstractApi;

class AppsList extends AbstractApi
{
    protected $module = 'apps';

    /**
     * Get Apps List.
     *
     * @param array $active
     *
     * @return array $list
     */
    public function disAppsList($active = 1)
    {
        $module  = $this->getModule();
        $config  = Pi::config('', $module);
        $model  = $this->getModel($this->getModule());
        $select = $model->select();
        $select->where(array('active' => $active));
        $select->columns(array('id', 'name', 'title', 'icon'));
        $select->order(array('nav_order ASC'));
        $rowset = $model->selectWith($select);
        foreach ($rowset as $row) {
            $id = (int) $row['id'];
            $item = array(
                'name'  => $row['name'],
                'title' => $row['title'],
                'icon'  => $config['icon_upload_path'] . '/' . $row['icon'],
                'url'   => Pi::service('url')->assemble(
                                'apps',
                                array($this->module, 'id' => $row['id'])
                           ),
            );
            $list[$id] = $item;
        }

        return $list;
    }


}
