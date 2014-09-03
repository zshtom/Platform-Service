<?php
/**
 * Pi Engine (http://www.social-touch.com/)
 * @link      http://www.social-touch.com/ for the Pi Engine source repository
 * @copyright Copyright (c) Pi Engine (http://www.social-touch.com/)
 */
namespace Module\Freetrial\Controller\Admin;

use Pi\Mvc\Controller\ActionController;
use Pi\Paginator\Paginator;
use Pi;
use Zend\Db\Sql\Predicate;


/**
 * Feature list:
 * 1.Show freetrial user information
 * @author Author Name <[lichunhui_lichunhui@social-touch.com]>
 */
class IndexController extends ActionController
{
    /**
     * @return array|void
     */
    public function indexAction()
    {
        $type = $this->params('type',null);
        $keyword = $this->params('keyword',null);
        $page = $this->params('p', 1);
        $flag = $this->params('f', 0);

        $where = array('flag' => $flag);

        if ($keyword) {
            $where["$type like ?"] = '%' . $keyword . '%';
        }

        $limit  = $this->config('item_per_page') ?: 2;
        $offset = (int) ($page - 1) * $limit;
        $model = $this->getModel('freetrial');
        $select = $model->select()
            ->where($where)
            ->limit($limit)
            ->offset($offset)
            ->order('id DESC');
        $rowset = $model->selectWith($select);

        $pages = array();

        foreach ($rowset as $row) {
            $pages[] = array(
                'id'        => $row['id'],
                'name'      => $row['name'],
                'title'     => $row['title'],
                'company'   => $row['company'],
                'email'     => $row['email'],
                'phone'     => $row['phone'],
                'id'         => $row['id'],
                'url'   => $this->url('', array(
                        'action'    => 'view',
                        'id'        => $row['id'],
                    )),
            );
        }

        $count = $model->count($where);
        $paginator = Paginator::factory($count, array(
            'limit'       => $limit,
            'page'        => $page,
            'url_options' => array(
                'page_param'    => 'p',
                'total_param'   => 't',
                'params'        => array(
                    'f'             => $flag,
                    'keyword'      => $keyword,
                    'type'          => $type,
                ),
            )
        ));
        $this->view()->assign(array(
            'paginator'     => $paginator,
            'pages'         => $pages,
            'type'         => $type,
            'keyword'         => $keyword,
        ));
        $this -> view()->setTemplate('test-list');
    }

    /**
     * @return mixed
     */
    public function deleteAction()
    {
        $id = $this->params('id');
        $model = $this->getModel('freetrial');
        $row = $model->find($id);
        $row->delete();
        return $this->jump(
            array('action' => 'index'),
            _a('Page deleted successfully.')
        );
    }

    /**
     *
     */
    public function batchdeleteAction(){
        echo json_encode(array('msg' => 'ok'));
        $all = trim($this->params('ids'), ',');
        $ids = explode(",",$all);
        $model = $this->getModel('freetrial');

        foreach($ids as $val){
            $row = $model->find($val);
            $row->delete();
        }
    }
}