<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link         http://code.pialog.org for the Pi Engine source repository
 * @copyright    Copyright (c) Pi Engine http://pialog.org
 * @license      http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Apps\Model;

use Pi\Application\Model\Model;

/**
 * Model class for Page
 *
 * @author Taiwen Jiang <taiwenjiang@tsinghua.org.cn>
 */
class Apps extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $columns = array(
        'id', 'name', 'title', 'slug', 'content', 'markup', 'active',
        'uid', 'time_created', 'time_updated', 'seo_title', 'seo_keywords', 'seo_description',
        'nav_order', 'theme', 'layout',
        'icon', 'summary', 'time_release',
    );
}
