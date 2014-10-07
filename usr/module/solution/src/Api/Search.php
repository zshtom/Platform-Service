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
use Pi\Search\AbstractSearch;

/**
 * Class for module search
 *
 * @author Taiwen Jiang <taiwenjiang@tsinghua.org.cn>
 */
class Search extends AbstractSearch
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'solution';

    /**
     * {@inheritDoc}
     */
    protected $meta = array(
        'id'            => 'id',
        'title'         => 'title',
        'content'       => 'content',
        'time_created'  => 'time_created',
        'user'          => 'uid',
    );

    /**
     * {@inheritDoc}
     */
    protected function buildLink(array $item)
    {
        $link = Pi::service('url')->assemble(
            'solution',
            array('module' => $this->module, 'id' => $item['id'])
        );

        return $link;
    }
}
