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
           $end=134217727;
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
        $columns = array('id', 'name', 'title','company','email', 'phone','time');
        $model  = $this->getModel('freetrial');
        $select = $model->select()
            ->columns($columns)
            ->order('id ASC');
        $data = $model->selectWith($select);
        $value = $data->toArray();
            foreach ($value as $v)
            {
                $v = implode(",",$v);
                $temp[] = $v;
            }
            $t="";
            foreach($temp as $v){
                $t.="'".$v."'"."\n";
            }
        $source=substr($t,0,-1);
        d($value);
        d($source);

          $options = array(
       // Required
       'type'          => 'raw',
       // Optional
       'filename'      => 'list.xls',
       // Optional
       'content_type'   => 'application/octet-stream',
   );

//          $downloader = new Download;
//          $downloader->send($t, $options);
        Pi::service('file')->download($source,$options);
    }
}