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

        foreach ($rows as $key => $value) {
            $rows[$key]['icon'] = Pi::url('upload') . '/' . $module.'/'.$rows[$key]['icon'];
            $rows[$key]['url'] = Pi::url('').'/'.$module.'/index/detail/id-'.$rows[$key]['id'];
        }
        $result  = array(
            'items'   => $rows,
        );
        return $result;
    }
}