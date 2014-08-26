<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Apps\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Module\Apps\Form\AppForm;
use Module\Apps\Form\AppFilter;

/**
 * Index action controller
 */
class IndexController extends ActionController
{
    /**
     * List of custom apps
     */
    public function indexAction()
    {
        $model  = $this->getModel('apps');
        $select = $model->select()->order(array('active DESC', 'nav_order ASC', 'id DESC'));
        $rowset = $model->selectWith($select);
        $apps  = array();
        $menu   = array();
        foreach ($rowset as $row) {
            $app           = $row->toArray();
            $app['url']    = $this->url('apps', $app);
            if ($app['nav_order'] && $app['active']) {
                $menu[] = $app;
            } else {
                $apps[] = $app;
            }
        }
        $apps = array_merge($menu, $apps);

        $this->view()->assign('apps', $apps);
        $this->view()->assign('title', _a('Apps list'));
        $this->view()->setTemplate('apps-list');
    }

    /**
     * Add a custom app
     */
    public function addAction()
    {

        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $markup = $data['markup'];

            // Set slug
            if (!empty($data['slug'])) {
                $data['slug'] = Pi::api('text', 'apps')->slug($data['slug']);
            }

            // Set form
            $form = new AppForm('app-form', $markup);
            $form->setInputFilter(new AppFilter);
            $form->setData($data);
            if ($form->isValid()) {
                $values = $form->getData();

                if (empty($values['name'])) {
                    $values['name'] = null;
                }

                $values['active'] = 1;
                $values['uid'] = Pi::service('user')->getUser()->id;
                $values['time_created'] = time();
                unset($values['id']);

                // Save
                $id = Pi::api('api', $this->getModule())->add($values);

                if ($id) {
                    $message = _a('App data saved successfully.');
                    return $this->jump(array('action' => 'index'), $message);
                } else {
                    $message = _a('App data not saved.');
                }
            } else {
                $message = _a('Invalid data, please check and re-submit.');
            }
        } else {
            // Get markup type, default set html.
            $markup = $this->params('type', 'html');
            $form = new AppForm('app-form', $markup);
            $form->setAttribute(
                'action',
                $this->url('', array('action' => 'add'))
            );
            $message = '';
        }

        $this->view()->assign('markup', $markup);
        $this->view()->assign('form', $form);
        $this->view()->assign('title', _a('Add a App'));
        $this->view()->assign('message', $message);
        $this->view()->setTemplate('app-add');
    }

    /**
     * Edit a custom app
     */
    public function editAction()
    {
        if ($this->request->isPost()) {
            $data = $this->request->getPost();

            $id = $data['id'];
            $row = $this->getModel('apps')->find($id);

            // Set form
            $form = new AppForm('app-form', $row->markup);
            $form->setInputFilter(new AppFilter);
            $form->setData($data);
            if ($form->isValid()) {
                $values = $form->getData();

                if (empty($values['name'])) {
                    $values['name'] = null;
                }

                $values['time_updated'] = time();

                // Save
                $row->assign($values);
                $row->save();
//                 Pi::registry('apps')->clear($this->getModule());
                Pi::service('cache')->flush('module', $this->getModule());
                $message = _a('App data saved successfully.');
                return $this->jump(array('action' => 'index'), $message);
            } else {
                $message = _a('Invalid data, please check and re-submit.');
            }
        } else {
            $id = $this->params('id');
            $row = $this->getModel('apps')->find($id);
            $data = $row->toArray();
            $form = new AppForm('app-form', $row->markup);
            $form->setData($data);
            $form->setAttribute(
                'action',
                $this->url('', array('action' => 'edit'))
            );
            $message = '';
        }

        $this->view()->assign('form', $form);
        $this->view()->assign('title', _a('App edit'));
        $this->view()->assign('message', $message);
        $this->view()->setTemplate('app-edit');
    }

    /**
     * Delete a app
     *
     */
    public function deleteAction()
    {
        $id = $this->params('id');
        $row = $this->getModel('apps')->find($id);
        if ($row) {
//             if ($row->name) {
//                 // Replace condition by name to id when remove.
//                 $this->removeApp($row->name);
//             }
            $row->delete();
//             Pi::registry('apps')->clear($this->getModule());
//             Pi::registry('apps', $this->getModule())->flush();
            Pi::registry('nav', $this->getModule())->flush();
        }

        return $this->jump(
            array('action' => 'index'),
            _a('App deleted successfully.')
        );
    }

    /**
     * Activate/deactivate a app
     *
     */
    public function activateAction()
    {
        $id = $this->params('id');
        $row = $this->getModel('apps')->find($id);
        if ($row) {
            $row->active = $row->active ? 0 : 1;
            $row->save();
            Pi::registry('apps')->clear($this->getModule());
        }
        Pi::registry('apps', $this->getModule())->flush();
        Pi::registry('nav', $this->getModule())->flush();

        return $this->jump(
            array('action' => 'index'),
            _a('App updated successfully.')
        );
    }

    /**
     * Add apps to navigation menu
     *
     */
    public function menuAction()
    {
        $orders = $this->params('nav_order');
        $model = $this->getModel('apps');
        foreach ($orders as $id => $value) {
            $model->update(
                array('nav_order' => (int) $value),
                array('id' => (int) $id)
            );
        }
        Pi::registry('nav', $this->getModule())->flush();

        return $this->jump(
            array('action' => 'index'),
            _a('Apps navigation menu updated successfully.')
        );
    }

    /**
     * Add apps settings to system
     *
     * @param string $name
     * @param string $title
     * @return int
     */
    protected function setApp($name, $title)
    {
        if (!$name) {
            return;
        }
        $app = array(
            'section'       => 'front',
            'module'        => $this->getModule(),
            'controller'    => 'index',
            'action'        => $name,
        );
        $row = Pi::model('apps')->select($app)->current();
        if ($row) {
            $row->title = $title;
        }
        $row->save();
        Pi::registry('apps', $this->getModule())->flush();

        return $row->id;
    }

    /**
     * Remove from system apps settings
     *
     * @param string $name
     * @return int
     */
    protected function removeApp($name)
    {
        $where = array(
            'section'       => 'front',
            'module'        => $this->getModule(),
            'controller'    => 'index',
            'action'        => $name,
        );
        $count = Pi::model('apps')->delete($where);

        return $count;
    }
}
