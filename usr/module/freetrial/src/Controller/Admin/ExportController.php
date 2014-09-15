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

/**
 * Feature list:
 * 1.Export freetrial user information
 *
 * @author songshixin <[songshixin@social-touch.com]>
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
        $start =$this->params('start', null);
        $end = $this->params('end', null);
        $columns = array('id', 'name', 'title','company','email', 'phone','time');
        $model  = $this->getModel('freetrial');

        $select = $model->select()
            ->columns($columns)
           // ->where("time<$end")->where("time>$start")
            ->order('id ASC');
        $data = $model->selectWith($select);
        $value = $data->toArray();
        $items  = array();
        $name='down';
        header( "Cache-Control: public" );
        header( "Pragma: public" );
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=".$name.".xls");
        header('Content-Type:APPLICATION/OCTET-STREAM');
        foreach ($value as $row) {
            $items[] = array(
                'id' => $row['id'],
                'name' => $row['name'],
                'title' => $row['title'],
                'company' => $row['company'],
                'email' => $row['email'],
                'phone' => $row['phone'],
                'time' => $row['time']
            );
        }
        echo "<table>";
        echo "<tr>";
        echo "<td>","ID","</td>","<td>","Name","</td>","<td>","Title","</td>","<td>","Company","</td>","<td>","Email","</td>","<td>","Phone","</td>","<td>","Time","</td>";
        echo "</tr>";
        foreach ($items as $item) {
            echo "<tr>";
            echo "<td>",$item['id'],"</td>";
            echo "<td>",$item['name'],"</td>";
            echo "<td>",$item['title'],"</td>";
            echo "<td>",$item['company'],"</td>";
            echo "<td>",$item['email'],"</td>";
            echo "<td>",$item['phone'],"</td>";
            echo "<td>",_date($item['time']),"</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}