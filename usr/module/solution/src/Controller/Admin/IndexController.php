<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Solution\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Module\Solution\Form\SolutionForm;
use Module\Solution\Form\SolutionFilter;

use Module\Solution\Form\DescForm;
use Module\Solution\Form\DescFilter;

use Pi\File\Transfer\Upload;

define('APPS', 'apps');

/**
 * Index action controller
 */
class IndexController extends ActionController
{
    /**
     * List of custom solutions
     */
    public function indexAction()
    {
        $module = $this->getModule();
        $model  = $this->getModel($module);
        $select = $model->select()->order(array('nav_order ASC', 'id DESC'));
        $rowset = $model->selectWith($select);

        $rootUrl    = $this->rootUrl();

        $solutions  = array();
        $menu   = array();
        foreach ($rowset as $row) {
            $solution           = $row->toArray();
            $solution['url']    = $this->url('solution', $solution);
            $solution['icon']   = $rootUrl . '/' . $solution['icon'];
            if ($solution['nav_order'] && $solution['active']) {
                $menu[] = $solution;
            } else {
                $solutions[] = $solution;
            }
        }
        $solutions = array_merge($menu, $solutions);

        $this->view()->assign('solutions', $solutions);
        $this->view()->assign('title', _a('Solutions list'));
        $this->view()->setTemplate('solutions-list');
    }

    /**
     * Add a solution.
     */
    public function addAction()
    {
        $module = $this->getModule();
        $config = Pi::config('', $module);
        $apps = Pi::api('api', APPS)->getAppsList(1);
        $data = array();

        $appsRow = $this->_getSolutionApps(10);

        if ($this->request->isPost()) {
            $data = $this->request->getPost();

            // Set form
            $form = new SolutionForm('solution-form');
            $form->setInputFilter(new SolutionFilter);
            $form->setData($data);

            if ($form->isValid()) {
                $values = $form->getData();

                if (empty($values['name'])) {
                    $values['name'] = null;
                }
                if (empty($values['slug'])) {
                    $values['slug'] = null;
                }

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
                Pi::registry('nav', $this->getModule())->flush();

                if ($id) {
                    $message = _a('Solution data saved successfully.');

                    // Try save apps.
                    $apps = $data['solution_app'];
                    d($apps);
                    foreach ($apps as $app) {
                        if ($app['id']) {
                            $app = array(
                                'solution'      => $id,
                                'app'           => $app['app'],
                                'title'         => $app['title'],
                                'icon'          => $app['icon_url'],
                                'description'   => $app['description'],
                                'time_created'  => time(),
                            );

                            try {
                                $appRow = Pi::model('solution_app', $this->getModule())->createRow($app);
                                $appRow->save();
                            } catch (\Exception $exception) {
                                $message .= '<li>' . $app['title'] . _a(' can\'t not save:') . '</li>';
                                $message .= $exception->getMessage();
                            }
                        }
                    }

//                     $appsRow = $this->getModel('solution_app')->find($id, 'solution');
//                     d($appsRow);

                    return $this->jump(array('action' => 'index'), $message);
                } else {
                    $message = _a('Solution data not saved.');
                }
            } else {
                $form = $this->_appsListForm($form, $data);

                $formGroups['general'] = $form->getInputElements();
                $formGroups['seo']  = $form->getSeoElements();
                $formGroups['checkbox'] = $form->getCheckboxElements();
                $formGroups['hidden'] = $form->getHiddenElements();

                $data['image'] = $data['icon'];
                $json_data = json_encode($data);
                $message = _a('Invalid data, please check and re-submit.');
            }
        } else {
            $form = new SolutionForm('solution-form');

//             $formGroups['general']  = $form->getInputElements();
//             $formGroups['seo']      = $form->getSeoElements();
//             $formGroups['checkbox'] = $form->getCheckboxElements();
//             $formGroups['hidden']   = $form->getHiddenElements();

//             $form->setGroups( array(
//                 'group1' => array(
//                     'label' => _a('Group 1'),
//                     'elemnts' => array(
//                         'title', 'nav_order', 'name', 'icon', 'slug',
//                         'summery', 'content',
//                     ),
//                 ),
//                 'seo' => array(
//                     'label' => _a('SEO Settings'),
//                     'elemnts' => array(
//                         'seo_title', 'seo_keywords', 'seo_description'
//                     ),
//                 ),
//             ));

//             $options = $form->getGroups();
//             d($options);

            foreach ($form as $ele) {
                $eleAttributes = $ele->getAttributes();
                if (isset($eleAttributes['type'])) {
                    $formGroups['general'][$eleAttributes['name']] = $eleAttributes['name'];
                }
            }

            // Add apps list.
            $form = $this->_appsListForm($form, $data);

            foreach ($form as $ele) {
                $eleAttributes = $ele->getAttributes();
                if (isset($eleAttributes['type'])) {
                    if (!in_array($eleAttributes['name'], $formGroups['general'])) {
                        $formGroups['apps'][$eleAttributes['name']] = $eleAttributes['name'];
                    }
                }
            }

//             d($formElements);
//             d($formGroups);

//             $form = $this->getForm($configs, $module);

            $form->setAttribute(
                'action',
                $this->url('', array('action' => 'add'))
            );

            $data['image'] = '';
            $json_data = json_encode($data);

            $message = '';
        }

        $solution_apps = array();

        $this->view()->assign('formGroups', $formGroups);
        $this->view()->assign('solution_apps', $solution_apps);
//         $this->view()->assign('apps', $apps);
        $this->view()->assign('module', $module);
        $this->view()->assign('form', $form);
        $this->view()->assign('content', $json_data);
        $this->view()->assign('title', _a('Add a solution'));
        $this->view()->assign('message', $message);
        $this->view()->setTemplate('solution-add');
    }

    /**
     * setIconPath()
     *   - Set the icon full path.
     *
     * @param array $list
     *
     * @return multitype:string
     */
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
     * Edit a custom app
     */
    public function editAction()
    {
        $module = $this->getModule();

        if ($this->request->isPost()) {
            $data = $this->request->getPost();

            $id = $data['id'];
            $row = $this->getModel($module)->find($id);

            // Set form
            $form = new SolutionForm('solution-form');
            $form->setInputFilter(new SolutionFilter);
            $form->setData($data);
            if ($form->isValid()) {
                $values = $form->getData();

                if (empty($values['name'])) {
                    $values['name'] = null;
                }
                if (empty($values['slug'])) {
                    $values['slug'] = null;
                }

                $values['time_updated'] = time();

                // Fix upload icon url
                $iconImages = $this->setIconPath(array($data));

                if (isset($iconImages[0]['filename'])) {
                    $values['icon'] = $iconImages[0]['filename'];
                }

                // Save
                $row->assign($values);
                $row->save();

                Pi::service('cache')->flush('module', $this->getModule());
                Pi::registry('solution', $this->getModule())->clear($this->getModule());
                Pi::registry('nav', $this->getModule())->flush();

                $message = _a('Solution data saved successfully.');

                return $this->jump(array('action' => 'index'), $message);

            } else {
                $data['image'] = $data['icon'];
                $json_data = json_encode($data);
                $message = _a('Invalid data, please check and re-submit.');
            }
        } else {
            $id = $this->params('id');
            $row = $this->getModel($module)->find($id);
            $data = $row->toArray();
            $form = new SolutionForm('solution-form');
            $form->setData($data);
            $form->setAttribute(
                'action',
                $this->url('', array('action' => 'edit'))
            );
            $message = '';

            $rootUrl    = $this->rootUrl();
            $data['image'] = $rootUrl . '/' . $data['icon'];
            $json_data = json_encode($data);
        }

        $this->view()->assign('module', $this->getModule());
        $this->view()->assign('form', $form);
        $this->view()->assign('content', $json_data);
        $this->view()->assign('title', _a('Solution edit'));
        $this->view()->assign('message', $message);
        $this->view()->setTemplate('solution-edit');
    }

    /**
     * Delete a app
     *
     */
    public function deleteAction()
    {
        $module = $this->getModule();
        $id = $this->params('id');
        $row = $this->getModel($module)->find($id);
        if ($row) {

            $row->delete();
            // Clear cache
            Pi::registry('solution', $module)->clear($module);
            Pi::registry('solution', $module)->flush();
            Pi::service('cache')->flush('module', $this->getModule());
            Pi::registry('nav', $this->getModule())->flush();
        }

        return $this->jump(
            array('action' => 'index'),
            _a('Solution deleted successfully.')
        );
    }

    /**
     * Activate/deactivate a app
     *
     */
    public function activateAction()
    {
        $module = $this->getModule();
        $id = $this->params('id');
        $row = $this->getModel($module)->find($id);
        if ($row) {
            $row->active = $row->active ? 0 : 1;
            $row->save();
            Pi::registry('solution', $module)->clear($this->getModule());
        }
        Pi::service('cache')->flush('module', $this->getModule());
        Pi::registry('solution', $module)->flush();
        Pi::registry('nav', $this->getModule())->flush();

        return $this->jump(
            array('action' => 'index'),
            _a('Solution updated successfully.')
        );
    }

    /**
     * Add solution to navigation menu
     *
     */
    public function menuAction()
    {
        $module  = $this->getModule();
        $model  = $this->getModel($module);
        $orders = $this->params('order');
        foreach ($orders as $id => $value) {
            $model->update(
                array('nav_order' => (int) $value),
                array('id' => (int) $id)
            );
        }
        Pi::registry('nav', $this->getModule())->flush();

        return $this->jump(
            array('action' => 'index'),
            _a('Solutions navigation menu updated successfully.')
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

    protected function thumbUrl()
    {
        $module = $this->getModule();
        $config = Pi::config('', $module);

        return $this->rootUrl() . '/' . $config['icon_upload_path'];
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

    protected function thumbPath()
    {
        $module = $this->getModule();
        $config = Pi::config('', $module);

        return $this->rootPath() . '/' . $config['icon_upload_path'];
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

    /**
     * descriptionAction()
     *   - Admin solution description.
     */
    public function descriptionAction()
    {
        $module = $this->getModule();
        $config = Pi::config('', $module);

        if ($this->request->isPost()) {
            $data = $this->request->getPost();

            // Set form
            $form = new DescForm('solution-desc-form', 'html');
            $form->setInputFilter(new DescFilter);
            $form->setData($data);

            if ($form->isValid()) {
                $values = $form->getData();

                // Save
                $description = Pi::user()->data->set(0, 'solutions_description', $values['description']);

            } else {
                $message = _a('Invalid data, please check and re-submit.');
            }
        } else {
            $data['description'] = Pi::user()->data->get(0, 'solutions_description');
            if (empty($data['description'])) {
                $data['description'] = '<div style="font-size: 20px;">Content is empty.</div>';
            }
            $form = new DescForm('solution-desc-form', 'html');
            $form->setData($data);
            $message = '';
        }

        $this->view()->assign('form', $form);
        $this->view()->assign('title', _a('Solutions Description'));
        $this->view()->assign('message', $message);
        $this->view()->setTemplate('solution-description');

    }

    /**
     * _appsListForm()
     *   - Apps list form.
     *
     * @param unknown $from
     * @param array $sibling
     * @return \Module\Solution\Controller\Admin\Form
     */
    protected function _appsListForm($form, $data)
    {

        $apps = Pi::api('api', APPS)->getAppsList(1);

        $appElementFieldSet = array(
            'name' => 'extra_apps',
            'type' => 'fieldset',
            'options' => array(
                'label' => _a('Apps'),
                'id'    => 'edit-soultion-apps-list',
            ),
            'attributes' => array(
            	'id'   => 'test-id',
                'for'   => 'test-for',
            ),
        );

        $form->add($appElementFieldSet);
        $flags = 'apps-list';

        foreach ($apps as $key => $app) {

            $appElements = array(
                // extra_apps
                array(
                    'name' => 'extra_app_' . $key,
                    'type' => 'fieldset',
                    'options' => array(
                        'label' => ' ',
                    ),
                ),

                array(
                    'name'       => 'solution_app[' . $key . '][id]',
                    'options'    => array(
                        'class' => 'inline',
                        'label'     => $app['title'],
                    ),
                    'attributes' => array(
                        'value' => $data['solution']['app']['id'][$key],
                        'class' => 'inline',
                    ),
                    'type'          => 'checkbox',
                ),

                array(
                    'name'       => 'solution_app[' . $key . '][app]',
                    'attributes' => array(
                        'class' => 'inline',
                        'value' => $app['id'],
                        'readonly' => 'readonly'
                    ),
                    'type'          => 'hidden',
                ),

                array(
                    'class'      => 'self-class',
                    'name'       => 'solution_app[' . $key . '][title]',
                    'options'    => array(
                        'class' => 'inline',
                        'label'     => ' ',
                    ),
                    'attributes' => array(
                        'value' => $app['title'],
                        'class' => 'inline',
                        'readonly'  => 'readonly',
                    ),
                    'type'          => 'input',
                ),

                array(
                    'name'       => 'solution_app[' . $key . '][icon]',
                    'options'    => array(
                        'class' => 'inline',
                    ),
                    'attributes' => array(
                        'class' => 'inline',
                        'value' => '<img src="' . $app['icon'] . '" style="width: 80px;">',
                    ),
                    'type'          => 'html',
                ),

                array(
                    'name'       => 'solution_app[' . $key . '][icon_url]',
                    'attributes' => array(
                        'class' => 'inline',
                        'value' => $app['icon'],
                        'readonly' => 'readonly'
                    ),
                    'type'          => 'hidden',
                ),

                array(
                    'name'       => 'solution_app[' . $key . '][description]',
                    'options'    => array(
                        'label'     => ' ',
                    ),
                    'attributes' => array(
                        'class' => 'inline',
                        'value' => $data['solution']['app']['description'][$key],
                    ),
                    'type'          => 'textarea',
                ),

                array(
                    'name'       => 'solution_app[' . $key . '][publish]',
                    'attributes' => array(
                        'class' => 'inline',
                        'value' => _date($app['time_created'], null, 'NULL', 'NULL',
                            null, null, null, 'Y-m-d'),
                        'readonly' => 'readonly'
                    ),
                    'type'          => 'html',
                ),
            );

            foreach ($appElements as $element) {
                $form->add($element);
            }
        }

        return $form;
    }

    /**
     * _getSolutionApps()
     *   - Get solutions app.
     *
     * @param array $solution
     */
    protected function _getSolutionApps($solution) {

        $module = $this->getModule();
        $model  = $this->getModel('solution_app');

        $where = array(
                'solution' => $solution,
        );

        $select = $model->select()->order(array('id DESC'));
        $select->where($where);
        $rowset = $model->selectWith($select);

        foreach ($rowset as $row) {
            $app = $row->toArray();
            $solutionsApp[$app['id']] = $app;
        }

        return $solutionsApp;
    }

}
