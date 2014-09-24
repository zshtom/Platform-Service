<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Zto\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Module\Zto\Form\ContactForm;
use Module\Zto\Form\ContactFilter;

class FormController extends ActionController
{
    //初始化表单
     protected function renderForm()
    {
        $form = new ContactForm('contactForm');
        $form->setAttribute('action', $this->url('', array('action' => 'contact-us')));

        return $form;
    }

    //将数据添加到模板
    public function contactUsAction()
    {
        $form = $this->renderForm();
        //加入表单验证
        if ($this->request->isPost()) {

            $post = $this->request->getPost();//获去post的请求信息

            $form->setData($post);
            $form->setInputFilter(new ContactFilter);//指定过滤器
            if (!$form->isValid()) {//如果验证没有通过保留内容，输出错误信息
                $this->view()->assign('form', $form);
                $this->view()->assign('title', __('Please enter'));
                return ;
            }

            $data = $form->getData();//获取所有数据字段
            //var_dump($data);exit;

            //如果公司的名称在数组指定的值之中存在就输出状态信息
            if (in_array($data['company'], array('admin'))) {
                $this->view()->assign('form', $form);
                $this->view()->assign('title', __('Please enter'));
                $this->view()->assign('error', __('Invalid company, please try again!'));
                return ;
            }
            //die(var_dump($data));
            //Pi::log(var_dump("contactData",$data));
            //d($data);
            $model = $this->getModel('contact_us');
            //var_dump($model);exit;
            $row = $model->createRow($data);
            $row->save();
            if (!$row->id) {
                return false;
            }

            $this->view()->setTemplate(false);
            $this->view()->assign('content', __('Success!'));
            return ;
        }

        $this->view()->assign('form', $form);
        $this->view()->assign('title', __('Please enter'));
    }
}
