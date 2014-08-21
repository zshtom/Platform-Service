<?php
/**
 * Pi Engine (http://www.social-touch.com/)
 *
 * @link      http://www.social-touch.com/ for the Pi Engine source repository
 * @copyright Copyright (c) Pi Engine (http://www.social-touch.com/)
 */
namespace Module\Freetrial\Controller\Front;

use Pi\Mvc\Controller\ActionController;
use Module\Freetrial\Form\IndexForm;
use Module\Freetrial\Form\IndexFilter;
use Pi;

/**
 * Feature list:
 * 1.Information store in the database
 * 2.Associate with the template
 *
 * @author Author Name <[songshixin_songshixin@social-touch.com]>
 */
class IndexController extends ActionController
{
    /**
     * Associated with the template
     * @return IndexForm
     */
    protected function renderForm()
    {
        $form = new IndexForm('index');
        $form->setAttribute('action', $this->url('', array('action' => 'index')));

        return $form;
    }

    /**
     * Information store in the database
     * @return array|void
     */
    public function indexAction()
    {
        Pi::service('i18n')->loadModule('form');

        $form = $this->renderForm();
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            $form->setInputFilter(new IndexFilter);
            if (!$form->isValid()) {
                $this->view()->assign('form', $form);
                return ;
            }
            $data  = $form->getData();
            $columns = array('name', 'title', 'company', 'email','phone');
            foreach (array_keys($data) as $key) {
                if (!in_array($key, $columns)) {
                    unset($data[$key]);
                }
            }
            $row = $this->getModel('freetrial')->createRow($data);
            $row->save();
            $module = $this->getModule();
            $this->view()->setTemplate(false);
            $this->view()->assign('content', __('Success!'));
            $this->view()->assign('info', $data);
            return ;
        }
        $this->view()->assign('form', $form);
    }
}