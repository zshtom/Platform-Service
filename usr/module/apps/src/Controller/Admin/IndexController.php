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
use Module\Apps\Form\AppsForm;
use Module\Apps\Form\AppsFilter;

use Pi\File\Transfer\Upload;

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
        $this->view()->assign('title', _a('App list'));
        $this->view()->setTemplate('app-list');
    }

    /**
     * Add a custom app
     */
    public function addAction()
    {

        $module  = $this->getModule();
        $config         = Pi::config('', $module);

        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $markup = $data['markup'];

//             print('get post data: <pre>' . print_r($data, TRUE) . '</pre>');

            // Set form
            $form = new AppsForm('app-form', $markup);
            $form->setInputFilter(new AppsFilter);
            $form->setData($data);
            if ($form->isValid()) {
                $values = $form->getData();

                if (empty($values['name'])) {
                    $values['name'] = null;
                }
                if (empty($values['slug'])) {
                    $values['slug'] = null;
                }
                $values['active'] = 1;
                $values['user'] = Pi::service('user')->getUser()->id;
                $values['time_created'] = time();
                unset($values['id']);

                // Fix upload icon url
                $iconImages = $this->setIconPath(array($data));

                if (isset($iconImages[0]['image'])) {
                    $values['icon'] = $iconImages[0]['image'];
                }

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
            $markup = $this->params('type', 'html');
            $form = new AppsForm('app-form', $markup);
            $form->setAttribute(
                'action',
                $this->url('', array('action' => 'add'))
            );

            $message = '';
        }

        $this->view()->assign('markup', $markup);
        $this->view()->assign('form', $form);
        $this->view()->assign('title', _a('Add a app'));
        $this->view()->assign('message', $message);
        $this->view()->setTemplate('app-add');
    }

    protected function setIconPath($list) {
        $rootPath   = $this->rootPath();
        $rootUrl    = $this->rootUrl();
        $uploadPath = $this->tmpPath();
        $uploadUrl  = $this->tmpUrl() . '/';
        $prefixLen  = strlen($uploadUrl);

        $items = array();
        foreach ($list as $item) {
            if ($uploadUrl == substr($item['icon'], 0, $prefixLen)) {
                $imgName = substr($item['icon'], $prefixLen);
                $renamed = rename(
                        $uploadPath . '/' . $imgName,
                        $rootPath . '/' . $imgName
                );
                if ($renamed) {
                    $item['image'] = $rootUrl . '/' . $imgName;
                }
            }
            $items[] = $item;
        }

        return $items;
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
            $form = new AppsForm('app-form', $row->markup);
            $form->setInputFilter(new AppsFilter);
            $form->setData($data);
            if ($form->isValid()) {
                $values = $form->getData();

                if (empty($values['name'])) {
                    $values['name'] = null;
                }
                if (empty($values['slug'])) {
                    $values['slug'] = null;
                }
                if (!$values['name'] || $row->name != $values['name']) {
                    $this->removeApp($row->name);
                }
                if ($values['name']) {
                    $this->setApp($values['name'], $values['title']);
                }
                $values['time_updated'] = time();

                // Save
                $row->assign($values);
                $row->save();
                Pi::registry('apps')->clear($this->getModule());
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
            $form = new AppsForm('app-form', $row->markup);
            $form->setData($data);
            $form->setAttribute(
                'action',
                $this->url('', array('action' => 'edit'))
            );
            $message = '';

            $data['image'] = $data['icon'];
//             print('Row data: <pre>' . print_r($data, TRUE) . '</pre>');
            $json_data = json_encode($data);
        }

        $this->view()->assign('form', $form);
        $this->view()->assign('content', $json_data);
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
//                 $this->removeApp($row->name);
//             }
            $row->delete();
            Pi::registry('apps')->clear($this->getModule());
            Pi::registry('apps', $this->getModule())->flush();
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
//             Pi::registry('apps')->clear($this->getModule());
        }
//         Pi::registry('apps', $this->getModule())->flush();
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
        $orders = $this->params('order');
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
//         $app = array(
//             'section'       => 'front',
//             'module'        => $this->getModule(),
//             'controller'    => 'index',
//             'action'        => $name,
//         );
//         $row = Pi::model('apps')->select($app)->current();
//         if ($row) {
//             $row->title = $title;
//         } else {
//             $app = array(
//                 'section'       => 'front',
//                 'module'        => $this->getModule(),
//                 'controller'    => 'index',
//                 'action'        => $name,
//                 'title'         => $title,
//                 'block'         => 1,
//                 'custom'        => 0,
//             );
//             $row = Pi::model('apps')->createRow($app);
//         }
        $row->save();
//         Pi::registry('apps', $this->getModule())->flush();

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

    /**
     * Get root URL
     *
     * @return string
     */
    protected function rootUrl()
    {
        return Pi::url('upload') . '/' . $this->getModule();
    }

    /**
     * Get root path for upload
     *
     * @return string
     */
    protected function rootPath()
    {
        return Pi::path('upload') . '/' . $this->getModule();
    }

    /**
     * Get tmp upload URL
     *
     * @return string
     */
    protected function tmpUrl()
    {
        return Pi::url('upload/_tmp');
    }

    /**
     * Get tmp upload path
     *
     * @return string
     */
    protected function tmpPath()
    {
        return Pi::path('upload/_tmp');
    }

    /**
     * Upload image files
     *
     * Store files to a tmp dir and will be moved to regular dir on submission
     */
    public function uploadAction()
    {
        $return = array(
            'status'    => 1,
            'message'   => '',
            'image'     => '',
        );
        $rename         = '%random%';
        $destination    = $this->tmpPath();
        $uploadUrl      = $this->tmpUrl();

        $module         = $this->getModule();
        $config         = Pi::config('', $module);

        if ($config['icon_media']) {
            $exts = explode(',', $config['icon_media']);
            $exts = array_filter(array_walk($exts, 'trim'));
            $extensions = implode(',', $exts);
        }
        $extensions     = $extensions ?: 'jpg,png,gif';
        $maxFile        = (int) $config['icon_max_size']  * 1024;
        $maxSize        = array();
        if ($config['icon_max_width']) {
            $maxSize['width'] = (int) $config['icon_max_width'];
        }
        if ($config['icon_max_height']) {
            $maxSize['height'] = (int) $config['icon_max_height'];
        }

        $uploader = new Upload(array('rename' => $rename));
        $uploader->setDestination($destination)->setExtension($extensions);

        if ($maxFile) {
            $uploader->setSize($maxFile);
        }
        if ($maxSize) {
            $uploader->setImageSize($maxSize);
        }

        if ($uploader->isValid()) {
            $uploader->receive();
            $file = $uploader->getUploaded('image');
            $return['image'] = $uploadUrl . '/' . $file;
            $return['uploader'] = '<pre>' . print_r($uploader, TRUE) . '</pre>';
        } else {
            $messages = $uploader->getMessages();
            $return = array(
                'status'    => 0,
                'image'     => '',
                'message'   => implode('; ', $messages),
                'uploader'  => '<pre>' . print_r($uploader, TRUE) . '</pre>',
            );
        }

        return $return;
    }
}
