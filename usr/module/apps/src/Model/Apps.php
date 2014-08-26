<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link         http://code.pialog.org for the Pi Engine source repository
 * @copyright    Copyright (c) Pi Engine http://pialog.org
 * @license      http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Appas\Model;

use Pi\Application\Model\Model;

/**
 * Model class for Apps
 *
 * @author Taiwen Jiang <taiwenjiang@tsinghua.org.cn>
 */
class Apps extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $columns = array(
        'id', 'name', 'title', 'summery', 'content', 'markup', 'active',
        'uid', 'time_release', 'time_created', 'time_updated',
        'icon',
        'nav_order'
    );
}
