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
     * Add a new app and register to system apps settings if name is available
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

//         Pi::registry('apps')->clear($this->getModule());

        return $id;
    }

    /**
     * Delete a app and remove from system settings
     *
     * @param string|int $name Name or ID
     * @return boolean
     */
    public function delete($id)
    {
        if (is_int($id)) {
            $row = Pi::model('apps', $this->getModule())->find($id);
        } else {
            $row = Pi::model('apps', $this->getModule())->find($id, 'id');
        }
        if (!$row) {
            return false;
        }
        $row->delete();

        if (!$row->name) {
            return true;
        }
        $where = array(
            'section'       => 'front',
            'module'        => $this->getModule(),
            'controller'    => 'index',
            'action'        => $row->name,
        );
        Pi::model('apps')->delete($where);

//         Pi::registry('apps')->clear($this->getModule());

        return true;
    }
}
