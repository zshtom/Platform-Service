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
    /*
    protected $appColumns = array(
        'name', 'title', 'slug', 'content', 'markup', 'active',
        'user', 'time_created', 'seo_title', 'seo_keywords', 'seo_description'
    );
    */

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

        if (!$row->name) {
            return $id;
        }
//         $app = array(
//             'section'       => 'front',
//             'module'        => $this->getModule(),
//             'controller'    => 'index',
//             'action'        => $row->name,
//             'title'         => $row->title,
//             'block'         => 1,
//             'custom'        => 0,
//         );
//         $row = Pi::model('page')->createRow($app);
//         $row->save();

//         Pi::registry('apps')->clear($this->getModule());

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
//         $where = array(
//             'section'       => 'front',
//             'module'        => $this->getModule(),
//             'controller'    => 'index',
//             'action'        => $row->name,
//         );
//         Pi::model('page')->delete($where);

//         Pi::registry('apps')->clear($this->getModule());

        return true;
    }

    /**
     * Get Apps List.
     *
     * @param array $active
     *
     * @return array $list
     */
    public function appsList($active = 1)
    {
        $list = array();


        $where = array(
            'active'  => $active,
        );

        // Get article result set
        $module    = $this->getModule();
        $rowset = Pi::model('apps', $module)->select($where);


//         $rowset = Pi::model('apps', $this->getModule())->select($active, 'active');

//         $select = $model->select();
//         $select->where(array('active' => $active));
//         $select->columns(array('id'));
//         $select->order(array('nav_order ASC'));
//         print('Select: <pre>' . print_r($select, TRUE) . '</pre>');
//         $rowset = $model->selectWith($select);
//         print('Select: <pre>' . print_r($rowset, TRUE) . '</pre>');
        foreach ($rowset as $row) {
//             print('Get module from API: <pre>' . print_r($row['id'], TRUE) . '</pre>');
            $id = (int) $row['id'];
            $item = array(
                'id'    => $id,
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
