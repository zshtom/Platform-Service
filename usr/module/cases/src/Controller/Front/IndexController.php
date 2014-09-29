<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Cases\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Db\RowGateway\RowGateway;
use Zend\Mvc\MvcEvent;
use Zend\Db\Sql\Expression;
use Zend\View\Model\JsonModel;

/**
 * Index controller
 *  * 
 * 1. Case homepage
 * 2. Case detail page
 * 
 * @author chenxiaoliang <chenxiaoliang@social-touch.com>
 */
class IndexController extends ActionController
{

    public function indexAction()
    {
        $solutionId = $this->params('solution_id');
        $solutionList = Pi::api('api', 'solution')->getSolutionList();
        if(!empty($solutionList)){
            foreach ($solutionList as &$solution) {
                $solution['url'] = $this->url('', array('action' => 'getList','solution_id' => $solution['id']));
                if(!empty($solutionId) && $solution['id'] == $solutionId){
                    $solution['active'] = true;
                }
            }
        }
        if(empty($solutionId)) {
            $solutionId = current(array_keys($solutionList));
            //$solutionList[$solutionId]['active'] = true;
        }
        $caseList = array();
        $casesIdList = Pi::api('api', 'solution')->getCasesList($solutionId);
        $iconPath = Pi::url('upload') . '/' . $this->getModule(); 
        if(!empty($casesIdList)){
            $model  = $this->getModel('cases');
            $where = array('id' => array_keys($casesIdList));
            $select = $model->select()->where($where);
            $list = $model->selectWith($select);
            if(!empty($list)){
                foreach ($list as $item) {
                    $item = $item->toArray();
                    $item['url'] = $this->url('', array('action' => 'detail','id' => $item['id']));
                    $item['icon'] = $iconPath . $item['icon'];
                    $caseList[] = $item;
                }
            }
        }
        $this->view()->assign(array(
            'solutionList'  => $solutionList,
            'caseList'      => $caseList,
        ));
    }
    /**
     * case detail page
     *
     * @return ViewModel 
     */
    public function detailAction()
    {
        $id = $this->params('id');
        $caseInfo = $this->getModel('cases')->find($id);
        $this->view()->assign(array(
            'title'      => $caseInfo->title,
            'content'    => $caseInfo->content,
        ));
    }

    /**
     * ajax get case list
     *
     * @return json
     */
    public function getListAction()
    {
        $solutionId = $this->params('solution_id');
        $solutionList = Pi::api('api', 'solution')->getSolutionList();        
        if(empty($solutionId)) {
            $solutionId = current(array_keys($solutionList));
            $solutionList[$solutionId]['active'] = true;
        }
        $caseList = array();
        $casesIdList = Pi::api('api', 'solution')->getCasesList($solutionId);
        $iconPath = Pi::url('upload') . '/' . $this->getModule(); 
        if(!empty($casesIdList)){
            $model  = $this->getModel('cases');
            $where = array('id' => array_keys($casesIdList));
            $select = $model->select()->where($where);
            $list = $model->selectWith($select);
            if(!empty($list)){
                foreach ($list as $item) {
                    $item = $item->toArray();
                    $item['url'] = $this->url('', array('action' => 'getList','id' => $item['id']));
                    $item['icon'] = $iconPath . $item['icon'];
                    $caseList[] = $item;
                }
            }
        }
        return New JsonModel($caseList);
    }
}
