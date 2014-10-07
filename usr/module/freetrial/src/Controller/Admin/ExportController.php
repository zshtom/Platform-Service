<?php
/**
 * Pi Engine (http://www.social-touch.com/)
 *
 * @link      http://www.social-touch.com/ for the Pi Engine source repository
 * @copyright Copyright (c) Pi Engine (http://www.social-touch.com/)
 */
namespace Module\Freetrial\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Zend\Db\Sql\Predicate;
use Pi\File\Transfer\Download;

/**
 * Feature list:
 * 1.Export freetrial user information
 * @author lichunhui <[lichunhui@social-touch.com]>
 */
class ExportController extends ActionController
{

    /**
     * @return array|void
     */

    public function indexAction()
    {
        $start =$this->params('start', null);
        $end = $this->params('end', null);
        $end = strtotime($end);
        $start= strtotime($start);
        if (empty($start)&&empty($end)) {
           $end=time();
           $start=0;
        }
        $columns = array('id', 'name', 'title','company','email', 'phone','time');
        $model  = $this->getModel('freetrial');
        $select = $model->select()
            ->columns($columns)
            ->where("time<$end")->where("time>$start")
            ->order('id ASC');
        $rowset = $model->selectWith($select);
        $items  = array();
        foreach ($rowset as $row) {
            $items[$row->id] = $row->toArray();
        }
        $this->view()->assign('items', $items);
        $this->view()->assign('start', $start);
        $this->view()->assign('end', $end);
    }

    /**
     * export freetrial user-list by time
     */
    public function exportAction()
    {
        $response = $this->getEvent()->getResponse();
        $columns = array('id', 'name', 'title','company','email', 'phone','time');
        $model  = $this->getModel('freetrial');
        $select = $model->select()
            ->columns($columns)
            ->order('id ASC');
        $data = $model->selectWith($select);
        $value = $data->toArray();

        $fp = fopen('php://temp', 'a');
        fputcsv($fp,array(
            __('Id'),
            __('Name'),
            __('Title'),
            __('Company'),
            __('Email'),
            __('Phone'),
            __('Time'),
        ));

        foreach ($value as $v)
        {
            fputcsv($fp, array(
                $v['id'],
                $v['name'],
                $v['title'],
                $v['company'],
                $v['email'],
                $v['phone'],
                date('Y-m-d H:i:s', $v['time']),
            ));
        }

        rewind($fp);
        $output = stream_get_contents($fp);
        $output=mb_convert_encoding($output, "gbk", "UTF-8");
        
        $options = array(
           // Required
           'type'          => 'raw',
           // Optional
           'filename'      => 'list.csv',
           // Optional
           'content_type'   => 'application/octet-stream',
        );

        Pi::service('file')->download($output,$options);
    }
}