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
    public function caseList()
    {
        $module = $this->getModule();
        $config  = Pi::config('', $module);
        $model  = Pi::model('cases', $this->getModule());
        $select = $model->select();
        $select->columns(array('id', 'title', 'summary', 'icon', 'time_created'));
        $select->order(array('order ASC'));
        $rowset = $model->selectWith($select);
        $upload_path = Pi::url('upload') . '/' . $this->getModule();
        $list = array();
        if($rowset) {
            foreach ($rowset as $row) {
                $id = (int) $row['id'];
                $item = array(
                    'id'        => $row['id'],
                    'title'     => $row['title'],
                    'summary'   => $row['summary'],
                    'icon'      => $upload_path . $row['icon'],
                    'time_created' => $row['time_created'],
                    'url'       => Pi::url('').'/'.$this->module.'/index/detail/id-'.$row['id'],
                    'time_created'  => $row['time_created'],
                );
                $list[$id] = $item;
            }
        }

        return $list;
    }

}
