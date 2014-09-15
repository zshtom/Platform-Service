<?php
namespace Module\Cases\Block;

use Pi;

class Block
{
    public static function caseList($options, $module = null)
    {
        $columns = array('id', 'title', 'icon');
        $limit   = (int) $options['list-count'];
        $model   = Pi::model('cases', $module);
        $select  = $model->select()
                        ->columns($columns)
                        ->offset(0)
                        ->limit($limit)
                        ->order('order DESC');
        $rows    = $model->selectWith($select)->toArray();

        $result  = array(
            'items'   => $rows,
        );
        return $result;
    }
}