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
    /*
    protected $app_itemColumns = array(
        'name', 'title', 'slug', 'content', 'markup', 'active',
        'user', 'time_created', 'seo_title', 'seo_keywords', 'seo_description'
    );
    */

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
//         $app_item = array(
//             'section'       => 'front',
//             'module'        => $this->getModule(),
//             'controller'    => 'index',
//             'action'        => $row->name,
//             'title'         => $row->title,
//             'block'         => 1,
//             'custom'        => 0,
//         );
//         $row = Pi::model('page')->createRow($app_item);
//         $row->save();

//         Pi::registry('solution')->clear($this->getModule());

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
//         $where = array(
//             'section'       => 'front',
//             'module'        => $this->getModule(),
//             'controller'    => 'index',
//             'action'        => $row->name,
//         );
//         Pi::model('page')->delete($where);

//         Pi::registry('solution')->clear($this->getModule());

        return true;
    }
}
