<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Apps\Api;

use Pi;
use Pi\Application\Api\AbstractApi;

class Api extends AbstractApi
{
    protected $module = 'apps';

    /**
     * Add a new app and register to system app settings if name is available
     *
     * @param array $app
     *
     * @return int  App id
     */
    public function add($app)
    {
        $id = 0;

        // Set time_created
        if (!isset($app['time_created'])) {
            $app['time_created'] = time();
        }

        // Save
        $row = Pi::model('apps', $this->getModule())->createRow($app);
        $row->save();
        $id = (int) $row->id;
        if (!$id) {
            return $id;
        }

//         $apps_list = Pi::registry('apps')->read('active');

        if (!$row->name) {
            return $id;
        }

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
            $row = Pi::model('apps', $this->getModule())->find($name);
        } else {
            $row = Pi::model('apps', $this->getModule())->find($name, 'name');
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
     * Get Apps List.
     *
     * @param array $active
     *
     * @return array $list
     */
    public function getAppsList($active = 1)
    {
        $list = array();

        $where = array(
            'active'  => $active,
        );

        $module = $this->getModule();
        $config = Pi::config('', $module);

        $model  = Pi::model('apps', $this->getModule());
        $select = $model->select()->order(array('active DESC', 'nav_order ASC', 'id DESC'));
        $select = $model->select()->where($where);
        $rowset = $model->selectWith($select);

//         $select = $model->select()->order(array('active DESC', 'nav_order ASC', 'id DESC'));
//         $rowset = Pi::model($module, $module)->select($where);


        $upload_path = Pi::url('upload') . '/' . $this->getModule();

        foreach ($rowset as $row) {
            $id = (int) $row['id'];
            $item = array(
                'id'            => $id,
                'time_created'  => $row['time_created'],
                'name'          => $row['name'],
                'title'         => $row['title'],
                'summery'       => $row['summery'],
                'icon'          => $upload_path . '/' .$row['icon'],
                'slug'          => $row['slug'],
                'url'           => Pi::service('url')->assemble(
                    $module,
                    array($this->module, 'id' => $row['id'])
                ),
            );
            $list[$id] = $item;
        }

        return $list;
    }

}
