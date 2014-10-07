<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 * @package         Registry
 */

namespace Module\Solution\Registry;

use Pi;
use Pi\Application\Registry\AbstractRegistry;

/**
 * Solutions list
 *
 * @author Taiwen Jiang <taiwenjiang@tsinghua.org.cn>
 */
class Solution extends AbstractRegistry
{
    /** @var string Module name */
    protected $module = 'solution';

    /**
     * {@inheritDoc}
     */
    protected function loadDynamic($options = array())
    {
        $list = array();

        $model  = Pi::model('solution', $this->module);
        $select = $model->select();
        $select->where(array('active' => 1));
        $select->columns(array('id', 'name', 'title', 'summary', 'icon', 'slug'));

        // Add order by.
        $select->order(array('nav_order ASC', 'id DESC'));

        $rowset = $model->selectWith($select);

        foreach ($rowset as $row) {
            $id = (int) $row['id'];
            $item = array(
                'id'        => $id,
                'name'      => $row['name'],
                'title'     => $row['title'],
                'summary'   => $row['summary'],
                'icon'      => $row['icon'],
                'url'       => Pi::service('url')->assemble(
                    'solution',
                    array($this->module, 'id' => $row['id'])
                ),
            );
            $list[$id] = $item;
        }

        return $list;
    }

    /**
     * {@inheritDoc}
     * @param array
     */
    public function read()
    {
        $options = array();
        $result = $this->loadData($options);

        return $result;
    }

    /**
     * {@inheritDoc}
     * @param bool $name
     */
    public function create()
    {
        $this->clear('');
        $this->read();

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function setNamespace($meta = '')
    {
        return parent::setNamespace('');
    }

    /**
     * {@inheritDoc}
     */
    public function flush()
    {
        return $this->clear('');
    }
}
