<?php
/**
 * Pi Engine (http://www.social-touch.com/)
 *
 * @link      http://www.social-touch.com/ for the Pi Engine source repository
 * @copyright Copyright (c) Pi Engine (http://www.social-touch.com/)
 */
namespace Module\Freetrial\Controller\Admin;

use Pi\Mvc\Controller\ActionController;
use Pi;
use Module\Freetrial\My97DatePicker;
//use Module\Freetrial\phpexcel;

/**
 * Feature list:
 * 1.Export freetrial user information
 *
 * @author Author Name <[songshixin_songshixin@social-touch.com]>
 */
class ExportController extends ActionController
{
    public function indexAction()
    {
        $columns = array('id', 'name', 'title','company','email', 'phone');
        $model  = $this->getModel('freetrial');
        $select = $model->select();
        $rowset = $model->selectWith($select);
        $select = $model->select()
            ->columns($columns)
            ->order('id ASC');
        $rowset = $model->selectWith($select);
        $items  = array();
        foreach ($rowset as $row) {
            $items[$row->id] = $row->toArray();
        }

        $this->view()->assign('items', $items);

    }
    public function exportAction(){
          $start = $this->params('start', null);
          $end   = $this->params('end', null);
          $where    = array();
           if (!empty($start)&&!empty($end)) {
               $where['start'] = $start;
               $where['end'] = $end;
           }
        $name='down';
        header( "Cache-Control: public" );
        header( "Pragma: public" );
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=".$name.".xls");
        header('Content-Type:APPLICATION/OCTET-STREAM');
        $columns = array('id', 'name', 'title','company','email', 'phone');
        $model  = $this->getModel('freetrial');
        $select = $model->select();
        $rowset = $model->selectWith($select);
        $select = $model->select()
            ->columns($columns)
            ->where('date'>$where['start']&&'date'<$where['end'])
            ->order('id ASC');
        $rowset = $model->selectWith($select);
        $items  = array();
        foreach ($rowset as $row) {
            $items[$row->id] = $row->toArray();
        }
        echo "<table>";
        echo "<tr>";
        echo "<td>","ID","</td>","<td>","Name","</td>","<td>","Title","</td>","<td>","Company","</td>","<td>","Email","</td>","<td>","Phone","</td>";
        echo "</tr>";
        foreach ($items as $item) {
            echo "<tr>";
            echo "<td>",$item['id'],"</td>";
            echo "<td>",$item['name'],"</td>";
            echo "<td>",$item['title'],"</td>";
            echo "<td>",$item['company'],"</td>";
            echo "<td>",$item['email'],"</td>";
            echo "<td>",$item['phone'],"</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}