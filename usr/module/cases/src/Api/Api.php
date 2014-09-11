<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Cases\Api;

use Pi;
use Pi\Application\Api\AbstractApi;

class Api extends AbstractApi
{
    protected $module = 'cases';

    /**
     * Add a new case
     *
     * @param array $data
     *
     * @return int  Case id
     */
    public function add($data)
    {
        $id = 0;

        // Set time_created
        if (!isset($data['time_created'])) {
            $data['time_created'] = time();
        }

        // Save
        $row = Pi::model('cases', $this->getModule())->createRow($data);
        $row->save();
        return (int) $row->id;
    }

    /**
     * Delete a case
     *
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $row = Pi::model('cases', $this->getModule())->find($id);
        if (!$row) {
            return false;
        }
        return $row->delete();
    }

    /**
     * Get case List.
     *
     * @return array $list
     */
    public function caseList($active = 1)
    {
        $config  = Pi::config('', $this->module);
        $model  = $this->getModel($this->module);
        $select = $model->select();
        $select->where(array('active' => $active));
        $select->columns(array('id', 'title', 'summery', 'icon'));
        $select->order(array('order ASC'));
        $rowset = $model->selectWith($select);
        $list = array();
        if($rowset){
            foreach ($rowset as $row) {
                $id = (int) $row['id'];
                $item = array(
                    'id'        => $row['id'],
                    'title'     => $row['title'],
                    'summery'   => $row['summery'],
                    'icon'      => $config['icon_upload_path'] . '/' . $row['icon'],
                    'url'       => Pi::service('url')->assemble(
                                    'cases',
                                    array($this->module, 'id' => $row['id'])
                               ),
                );
                $list[$id] = $item;
            }
        }
        return $list;
    }

}
