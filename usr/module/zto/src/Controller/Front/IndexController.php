<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\zto\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Module\Zto\Form\ContactForm;
use Module\Zto\Form\ContactFilter;

class IndexController extends ActionController
{
    /**
     * A test page with a couple of API demos
     */
    public function indexAction()
    {

        // Assign multiple params
        $data = array(
            'text'      => 'helloword'
        );
        $this->view()->assign($data);
		
        // Assign one single param
        $this->view()->assign('testParam', 'springzto');

        // Specify template,
        // otherwise template will be set up as {controller}-{action}
        $this->view()->setTemplate('demo-zto');
    }
}
