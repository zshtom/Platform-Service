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

class Api extends AbstractApi
{
    protected $module = 'solution';

    /**
     * Add a new app and register to system app settings if name is available
     *
     * @param array $app_item
     *
     * @return int  App id
     */
    public function add($app_item)
    {
        $id = 0;

        // Set time_created
        if (!isset($app_item['time_created'])) {
            $app_item['time_created'] = time();
        }

        // Save
        $row = Pi::model('solution', $this->getModule())->createRow($app_item);
        $row->save();
        $id = (int) $row->id;
        if (!$id) {
            return $id;
        }

        if (!$row->name) {
            return $id;
        }

//         Pi::registry('solution', $module)->clear($this->getModule());
        Pi::registry('solution', $module)->clear($module);

        return $id;
    }

    /**
     * Delete a page and remove from system settings
     *
     * @param string|int $name Name or ID
     * @return boolean
     */
    public function delete($name)
    {
        if (is_int($name)) {
            $row = Pi::model('solution', $this->getModule())->find($name);
        } else {
            $row = Pi::model('solution', $this->getModule())->find($name, 'name');
        }
        if (!$row) {
            return false;
        }
        $row->delete();

        if (!$row->name) {
            return true;
        }

        return true;
    }

    /**
     * Get Solution List.
     *
     * @param array $active
     *
     * @return array $list
     */
    public function getSolutionList($active = 1)
    {
        $where = array(
            'active'  => $active,
        );

        $module = $this->getModule();
        $config = Pi::config('', $module);

        $model  = Pi::model($module, $this->getModule());
        $select = $model->select()->order(array('active DESC', 'nav_order ASC', 'id DESC'));
        $select = $model->select()->where($where);
        $rowset = $model->selectWith($select);

        foreach ($rowset as $row) {
            $id = (int) $row['id'];
            $item = array(
                'id'        => $id,
                'name'      => $row['name'],
                'title'     => $row['title'],
                'summery'   => $row['summery'],
                'icon'      => $row['icon'],
                'slug'      => $row['slug'],
                'url'       => Pi::service('url')->assemble(
                                'solution',
                                array($this->module, 'id' => $row['id'])
                               ),
            );
            $list[$id] = $item;
        }

        return $list;
    }
}
