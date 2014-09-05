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
     * @return int  case id
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
     * @return boolean
     */
    public function delete($id)
    {
        $row = Pi::model('cases', $this->getModule())->find($id);
        if (!$row) {
            return false;
        }
        return $row->delete();
    }
}
