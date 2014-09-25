<?php
namespace Module\about\Controller\Front;


use Pi\Mvc\Controller\ActionController;


class IndexController extends ActionController
{
    public function indexAction()
    {

        $this->view()->setTemplate('about-index');

        $this->view()->assign('content',__('What is Social-touch'));

    }
}







