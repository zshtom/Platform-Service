<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Apps\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Db\RowGateway\RowGateway;
use Zend\Mvc\MvcEvent;
use Zend\Db\Sql\Expression;

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
    /**
     * case detail page
     *
     * @return ViewModel 
     */
    public function detailAction()
    {
        $id = $this->params('id');
        $caseInfo = $this->getModel('cases')->find($id);
    }
}
