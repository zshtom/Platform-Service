<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Apps\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Db\RowGateway\RowGateway;
use Zend\Mvc\MvcEvent;
use Zend\Db\Sql\Expression;

class IndexController extends ActionController
{
    protected function render($row)
    {
        $this->view()->setTemplate('app-view');
        $apps_list = array();

        if (!$row instanceof RowGateway || !$row->active) {
            $description = Pi::user()->data->get(0, 'apps_description');
            $apps_list = Pi::api('api', $this->getModule())->getAppsList(1);

            $content = Pi::service('markup')->render(
                    $description,
                    'html'
            );

            $title      = __('Apps Description');
            $content    = $content;
        } else {
            $content    = $row->content;
            if ($content && 'pthml' != $markup) {
                $content = Pi::service('markup')->render(
                    $content,
                    'html'
                );
            }
            $title = $row->title;
            // update clicks
            $model = $this->getModel('apps');
            $model->increment('clicks', array('id' => $row->id));

            // Module config
            $config = Pi::config('', $this->getModule());
            // Set view
            $this->view()->headTitle($row->seo_title);
            $this->view()->headdescription($row->seo_description, 'set');
            $this->view()->headkeywords($row->seo_keywords, 'set');
            $this->view()->assign('config', $config);
        }

        $this->view()->assign(array(
            'title'     => $title,
            'content'   => $content,
            'apps_list' => $apps_list,
        ));

    }

    /**
     * App render
     *
     * @see Module\Apps\Route\Apps
     */
    public function indexAction()
    {
        $id     = $this->params('id');
        $name   = $this->params('name');
        $slug   = $this->params('slug');

        $row = null;
        if ($id) {
            $row = $this->getModel('apps')->find($id);
        } elseif ($name) {
            $row = $this->getModel('apps')->find($name, 'name');
        } elseif ($slug) {
            $row = $this->getModel('apps')->find($name, 'slug');
        }

        // Apps home page.
        $nav_main[0] = array(
            'id'       => 0,
            'title'    => __('Apps Description'),
            'url'      => $this->url('', $this->getModule()),
        );

        // Apps nav list.
        $nav = Pi::registry('nav', $this->getModule())->read();
        foreach ($nav as $key => $value) {
            $nav[$key]['url'] = Pi::url($this->getModule()).'/'.$value['id'];
        }

        // Add home page ontop list.
        $nav = $nav_main + $nav;

        if ($row && $row->active) {
            if (isset($nav[$row->id])) {
                $nav[$row->id]['active'] = 1;
            }

        } else {
            $nav[0]['active'] = 1;
        }
        $this->view()->assign('nav', $nav);

        $this->render($row);
    }

    /**
     * Transform an "action" token into a method name
     *
     * @param  string $action
     * @return string
     */
    public static function getMethodFromAction($action)
    {
        return 'indexAction';
    }
}
