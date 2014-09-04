<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link         http://code.pialog.org for the Pi Engine source repository
 * @copyright    Copyright (c) Pi Engine http://pialog.org
 * @license      http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Solution\Model;

use Pi\Application\Model\Model;

/**
 * Model class for Page
 *
 * @author Taiwen Jiang <taiwenjiang@tsinghua.org.cn>
 */
class Solution extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $columns = array(
        'id', 'user', 'name', 'title', 'icon', 'summery', 'content', 'markup', 'nav_order',
        'time_created', 'time_updated', 'active',
        'slug', 'seo_title', 'seo_keywords', 'seo_description',
        'theme', 'layout',
    );
}
