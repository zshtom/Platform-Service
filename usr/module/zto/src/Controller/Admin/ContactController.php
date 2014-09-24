<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Zto\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;

class ContactController extends ActionController
{
    public function listAction()
    {

        $columns = array('id', 'company', 'phone', 'email', 'address');
        $model  = $this->getModel('contact_us');
        $select = $model->select()
                        ->columns($columns)
                        ->order('id ASC');
        $rowset = $model->selectWith($select);
        $items  = array();
        foreach ($rowset as $row) {
            $items[$row->id] = $row->toArray();
        }

        $this->view()->assign('items', $items);
    }
}
