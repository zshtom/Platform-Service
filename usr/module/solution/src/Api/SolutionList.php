<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Solution\Api;

use Pi;
use Pi\Application\Api\AbstractApi;

class SolutionList extends AbstractApi
{
    protected $module = 'solution';

    /**
     * Get Solution List.
     *
     * @param array $active
     *
     * @return array $list
     */
    public function appsList($active = 1)
    {
        $module  = $this->getModule();
        $config  = Pi::config('', $module);
        $select = $model->select();
        $select->where(array('active' => $active));
        $select->columns(array('id', 'name', 'title', 'icon'));
        $rowset = $model->selectWith($select);
        foreach ($rowset as $row) {
            $id = (int) $row['id'];
            $item = array(
                'name'  => $row['name'],
                'title' => $row['title'],
                'icon'  => $config['icon_upload_path'] . '/' . $row['icon'],
                'url'   => Pi::service('url')->assemble(
                                'solution',
                                array($this->module, 'id' => $row['id'])
                           ),
            );
            $list[$id] = $item;
        }

        return $list;
    }


}
