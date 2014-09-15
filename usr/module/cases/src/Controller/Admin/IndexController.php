<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Cases\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Module\Cases\Form\CasesForm;
use Module\Cases\Form\CasesFilter;

use Pi\File\Transfer\Upload;

/**
 * Cases controller
 * 
 * Feature list:
 * 
 * 1. Cases list page for management
 * 2. Add/detete/edit cases
 * 
 * @author chenxiaoliang <chenxiaoliang@social-touch.com>
 */
class IndexController extends ActionController
{
    /**
     * List of cases
     */
    public function indexAction()
    {
        $model  = $this->getModel('cases');
        $select = $model->select()->order(array('active DESC', 'order ASC', 'id DESC'));
        $rowset = $model->selectWith($select);
        $rootUrl    = $this->rootUrl();
        $cases = array();
        foreach ($rowset as $row) {
            $row = $row->toArray();
            $row['icon']   = $rootUrl . '/' . $row['icon'];
            $cases[] = $row;
        }
        $this->view()->assign('cases', $cases);
        $this->view()->assign('title', _a('Case list'));
        $this->view()->setTemplate('case-list');
    }

    /**
     * Add a case
     */
    public function addAction()
    {

        $module  = $this->getModule();
        $config         = Pi::config('', $module);

        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            // Set form
            $form = new CasesForm('case-form');
            $form->setInputFilter(new CasesFilter);
            $form->setData($data);
            if ($form->isValid()) {
                $values = $form->getData();
                $values['active'] = 1;
                $values['uid'] = Pi::service('user')->getUser()->id;
                $values['time_created'] = time();
                unset($values['id']);
                // Fix upload icon url
                $iconImages = $this->setIconPath(array($data));

                if (isset($iconImages[0]['filename'])) {
                    $values['icon'] = $iconImages[0]['filename'];
                }
                // Save
                $id = Pi::api('api', $this->getModule())->add($values);

                if ($id) {
                    $message = _a('Case data saved successfully.');
                    return $this->jump(array('action' => 'index'), $message);
                } else {
                    $message = _a('Case data not saved.');
                }
            } else {
                $message = _a('Invalid data, please check and re-submit.');
            }
        } else {
            $form = new CasesForm('case-form');
            $form->setAttribute(
                'action',
                $this->url('', array('action' => 'add'))
            );

            $message = '';
        }

        $this->view()->assign('form', $form);
        $this->view()->assign('title', _a('Add a case'));        
        $this->view()->assign('content', '');
        $this->view()->assign('message', $message);
        $this->view()->setTemplate('case-edit');
    }

    protected function setIconPath($list) {
       $module = $this->getModule();
        $config = Pi::config('', $module);

        $rootPath   = $this->rootPath();
        $rootUrl    = $this->rootUrl();
        $uploadPath = $this->tmpPath();
        $uploadUrl  = $this->tmpUrl();
        $prefixLen  = strlen($uploadUrl);
        $items = array();
        foreach ($list as $item) {
            if ($uploadUrl == substr($item['icon'], 0, $prefixLen)) {
                $imgName = substr($item['icon'], $prefixLen);
                $renamed = rename(
                    $uploadPath . $imgName,
                    $rootPath . $imgName
                );
                if ($renamed) {
                    $item['image'] = $rootUrl . '/' . $imgName;
                    $item['filename'] = $imgName;
                }
            }
            $items[] = $item;
        }
        return $items;
    }

    /**
     * Edit a custom case
     */
    public function editAction()
    {
        if ($this->request->isPost()) {
            $data = $this->request->getPost();

            $id = $data['id'];
            $row = $this->getModel('cases')->find($id);

            // Set form
            $form = new CasesForm('case-form');
            $form->setInputFilter(new CasesFilter);
            $form->setData($data);
            if ($form->isValid()) {
                $values = $form->getData();               
                $values['time_updated'] = time();

                // Save
                $row->assign($values);
                $row->save();
                Pi::service('cache')->flush('module', $this->getModule());
                $message = _a('Case data saved successfully.');
                return $this->jump(array('action' => 'index'), $message);
            } else {
                $message = _a('Invalid data, please check and re-submit.');
            }
        } else {
            $id = $this->params('id');
            $row = $this->getModel('cases')->find($id);
            $data = $row->toArray();
            $form = new CasesForm('case-form');
            $form->setData($data);
            $form->setAttribute(
                'action',
                $this->url('', array('action' => 'edit'))
            );
            $message = '';

            $data['image'] = $data['icon'];
            $json_data = json_encode($data);
        }

        $this->view()->assign('form', $form);
        $this->view()->assign('content', $json_data);
        $this->view()->assign('title', _a('Case edit'));
        $this->view()->assign('message', $message);
        $this->view()->setTemplate('case-edit');
    }

    /**
     * Delete a case
     *
     */
    public function deleteAction()
    {
        $id = $this->params('id');
        $row = $this->getModel('cases')->find($id);
        if ($row) {
            $row->delete();
        }

        return $this->jump(
            array('action' => 'index'),
            _a('Case deleted successfully.')
        );
    }

    /**
     * Activate/deactivate a case
     *
     */
    public function activateAction()
    {
        $id = $this->params('id');
        $row = $this->getModel('cases')->find($id);
        if ($row) {
            $row->active = $row->active ? 0 : 1;
            $row->save();
        }

        return $this->jump(
            array('action' => 'index'),
            _a('Case updated successfully.')
        );
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
