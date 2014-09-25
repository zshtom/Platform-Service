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

        $this->view()->assign('socialintro',('时趣社会化营销整合服务，能够为客户提供最贴近社会化消费者的、专业的社会化营销管理服务，高度定制化的社会化营销战役服务，以及全面、智能的社会化数据挖掘分析服务与社会化商业咨询服务。'));


        $this->view()->assign('address','中国北京市朝阳区广渠路38号北京一轻大厦');
        $this->view()->assign('contactpost',('：10000'));
        $this->view()->assign('contactphone','400-691-1961');
        $this->view()->assign('contactemail','weiwei@social-touch.com');
        $this->view()->assign('people','：魏威');
        $this->view()->assign('phone','：13202054678');
        $this->view()->assign('consultphone','Consult Phone');
        $this->view()->assign('consultemail','E-mail：weiwei@social-touch.com');

    }
}








