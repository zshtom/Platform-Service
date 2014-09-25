<?php
namespace Module\contact\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;


class IndexController extends ActionController
{
    public function indexAction()
    {
        d(__('Test'));
        $this->view()->setTemplate('contact-index');

        $this->view()->assign('socialintro',__('What Social-touch can do'));


        $this->view()->assign('address',__('No.38 Guangqu street Chaoyang District in Beijing China'));
        $this->view()->assign('contactpost',('：10000'));
        $this->view()->assign('contactphone','400-691-1961');
        $this->view()->assign('contactemail','weiwei@social-touch.com');
        $this->view()->assign('people',__('weiwei'));
        $this->view()->assign('phone','：13202054678');
        $this->view()->assign('consultphone','Consult Phone');
        $this->view()->assign('consultemail','E-mail：weiwei@social-touch.com');

    }
}

//






