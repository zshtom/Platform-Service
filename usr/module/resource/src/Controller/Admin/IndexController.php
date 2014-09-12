<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14-9-3
 * Time: 下午5:01
 */

namespace Module\Resource\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Module\Resource\Form\BootstrapForm;
use Module\Resource\Form\BootstrapFilter;
use Pi\File\Transfer\Upload;
use Pi\File\Transfer\Download;

class IndexController extends ActionController
{
    public function indexAction()
    {
        $model = $this->getModel('resource');
        $select = $model->select()
            ->order('id DESC');
        $rowset = $model->selectWith($select);
        $items = array();
        foreach ($rowset as $row) {
            $items[] = array(
                'id' => $row['id'],
                'title' => $row['title'],
                'icon' => $row['icon'],
                'description' => $row['description'],
                'case_time' => $row['case_time'],
                'sid' => $row['sid'],
                'url' => $this->url('', array(
                        'action' => 'view',
                        'id' => $row['id'],
                    )),
            );
        }
        $this->view()->assign('items', $items);
        $this->view()->setTemplate('product_module-index');
    }

    public function addAction()
    {
        $messages = array();
        $form = new BootstrapForm('bootstrap');

        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            $form->setInputFilter(new BootstrapFilter);

            $options = array(
                'destination' => 'upload/resource/attach',
            );
            $uploader = Pi::service('file')->upload($options, true);
            $uploader->setExtension('pdf,doc');
            if (!$uploader->isValid()) {
                $uploader->receive();
                $savedFilename = $uploader->getUploaded('upload');
            } else {
                $errorMessages = $uploader->getMessages();
            }


            if ($form->isValid()) {
                $messages[] = _a('Form submitted successfully.');
            }
            if (!$form->isValid()) {
                $this->view()->assign('form', $form);
            }
            $data = $form->getData();
d($uploader);
            $iconImages = $this->setIconPath(array($data));

            if (isset($iconImages[0]['image'])) {
                $data['icon'] = $iconImages[0]['image'];
            }

            $values = array(
                'sid' => $data['sid'],
                'title' => $data['title'],
                'description' => $data['description'],
                'icon' => $data['icon'],
                'filename' => $savedFilename,
                'case_time' => time(),
            );
            $row = $this->getModel('resource')->createRow($values);
            $row->save();
            if ($row) {
                $message = _a('Resource data saved successfully');
                return $this->jump(array('action' => 'index'), $message);
            }
            $form = new BootstrapForm('bootstrap');
            if (!$row->id) {
                return false;
            }
        }
        $this->view()->assign(array(
            'form' => $form,
            'messages' => $messages,
        ));
        $this->view()->setTemplate('product_module-add');
    }

    protected function setIconPath($list)
    {
        $rootPath = $this->rootPath();
        $rootUrl = $this->rootUrl();
        $uploadPath = $this->tmpPath();
        $uploadUrl = $this->tmpUrl() . '/';
        $prefixLen = strlen($uploadUrl);

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
        return Pi::url('upload/resource');
    }

    /**
     * Get tmp upload path
     *
     * @return string
     */
    protected function tmpPath()
    {
        return Pi::path('upload/resource');
    }

    public function editAction()
    {
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $id = $data['id'];
            $row = $this->getModel('resource')->find($id);

            // Set form
            $form = new BootstrapForm('bootstrap');
            $form->setInputFilter(new BootstrapFilter);
            $form->setData($data);
            if ($form->isValid()) {
                $values = $form->getData();

                if (empty($values['description'])) {
                    $values['description'] = null;
                }
                $values['case_time'] = time();

                // Save
                $row->assign($values);
                $row->save();
                Pi::service('cache')->flush('module', $this->getModule());
                $message = _a('Resource data saved successfully.');
                return $this->jump(array('action' => 'index'), $message);
            } else {
                $data['image'] = $data['icon'];
                $json_data = json_encode($data);
                $message = _a('Invalid data, please check and re-submit.');
            }
        } else {
            $id = $this->params('id');
            $row = $this->getModel('resource')->find($id);
            $data = $row->toArray();
            $form = new BootstrapForm('bootstrap');
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
        $this->view()->assign('title', _a('Resource edit'));
        $this->view()->assign('message', $message);
        $this->view()->setTemplate('product_module-edit');
    }

    public function uploadAction()
    {
        $return = array(
            'status' => 1,
            'message' => '',
            'image' => '',
        );
        $rename = '%random%';
        $destination = $this->tmpPath();
        $uploadUrl = $this->tmpUrl();
        $module = $this->getModule();
        $config = Pi::config('', $module);

        if ($config['icon_media']) {
            $exts = explode(',', $config['icon_media']);
            $exts = array_filter(array_walk($exts, 'trim'));
            $extensions = implode(',', $exts);
        }
        $extensions = $extensions ? : 'jpg,png,gif';
        $maxFile = (int)$config['icon_max_size'] * 1024;
        $maxSize = array();
        if ($config['icon_max_width']) {
            $maxSize['width'] = (int)$config['icon_max_width'];
        }
        if ($config['icon_max_height']) {
            $maxSize['height'] = (int)$config['icon_max_height'];
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
                'status' => 0,
                'image' => '',
                'message' => implode('; ', $messages),
                'uploader' => '<pre>' . print_r($uploader, TRUE) . '</pre>',
            );
        }

        return $return;
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        $row = $this->getModel('resource')->find($id);
        if ($row) {
            $row->delete();
            //Pi::registry('nav', $this->getModule())->flush();
        }

        return $this->jump(
            array('action' => 'index'),
            _a('Resource deleted successfully.')
        );
    }
} 