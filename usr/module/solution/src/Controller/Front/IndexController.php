<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Solution\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Db\RowGateway\RowGateway;
use Zend\Mvc\MvcEvent;
use Zend\Db\Sql\Expression;

define('APPS', 'apps');
define('CASES', 'cases');
define('SOLUTION_APP', 'solution_app');
define('SOLUTION_CASE', 'solution_case');

class IndexController extends ActionController
{

    protected function render($row)
    {
        $module = $this->getModule();
        $this->view()->setTemplate('solution-view');
        $solutions_list = array();

        if (!$row instanceof RowGateway || !$row->active) {
            $description = Pi::user()->data->get(0, 'solutions_description');
            $solutions_list = Pi::api('api', $this->getModule())->getSolutionList(1);

            $content = Pi::service('markup')->render(
                $description,
                'html'
            );

            $title      = __('Solutions Description');
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
            $model = $this->getModel($module);
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
            'solutions_list' => $solutions_list,
        ));

    }

    /**
     * App render
     *
     * @see Module\Solution\Route\Solution
     */
    public function indexAction()
    {
        $module = $this->getModule();
        $id     = $this->params('id');
        $name   = $this->params('name');
        $slug   = $this->params('slug');

        $row = null;
        if ($id) {
            $row = $this->getModel($module)->find($id);
        } elseif ($name) {
            $row = $this->getModel($module)->find($name, 'name');
        } elseif ($slug) {
            $row = $this->getModel($module)->find($name, 'slug');
        }

        // Solution home page.
        $nav_main[0] = array(
            'id'       => 0,
            'title'    => __('Solutions Description'),
            'url'      => '/' . $this->getModule(),
        );

        // Solution nav list.
        $nav = Pi::registry('nav', $this->getModule())->read();
        foreach ($nav as $key => $value) {
            $nav[$key]['url'] = $value['url'].'/'.$value['id'];
        }
        // Add home page ontop list.
        $nav = $nav_main + $nav;

        // Get solution cases list.
        $case_row = $row;
        $case_row['solution'] = $row['id'];
        $solution_cases = $this->_getCaseListBySolution($case_row);

        // Get solution apps list.
        $solution_apps = $this->_getAppsListBySolution($case_row);

        if ($row && $row->active) {
            if (isset($nav[$row->id])) {
                $nav[$row->id]['active'] = 1;
            }

        } else {
            $nav[0]['active'] = 1;
        }
        // var_dump($nav);exit;

        $this->view()->assign('solution_cases', $solution_cases);
        $this->view()->assign('solution_apps', $solution_apps);

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

    /**
     * _getAppsListBySolution()
     *   - Get apps list by solution.
     *
     * @param array $solution
     *   - Soltuion data.
     *
     * @return array
     *   - Apps list.
     */
    protected function _getAppsListBySolution($solution = array()) {
        $apps = $list = array();
        // Apps list.
        $solution_apps = $this->_getSolutionApps($solution['solution']);

        if (Pi::service('module')->isActive(APPS)) {
            try {
                $apps = Pi::api('api', APPS)->getAppsList(1);
            } catch (\Exception $exception) {
                $apps = array();
            }
        }

        if ($apps) {
            foreach ($solution_apps as $s_case) {
                $list[] = $apps[$s_case['app']];
            }
        }

        return $list;
    }

    /**
     * _getCaseListBySolution()
     *   - Get cases list by solution.
     *
     * @param array $solution
     *   - Soltuion data.
     *
     * @return array
     *   - Cases list.
     */
    protected function _getCaseListBySolution($solution = array()) {
        $cases = $list = array();
        // Cases list.
        $solution_cases = Pi::api('api', $this->getModule())->getCasesList($solution['solution'], 'solution');

        if (Pi::service('module')->isActive(CASES)) {
            try {
                $cases = Pi::api('api', CASES)->caseList();
            } catch (\Exception $exception) {
                $cases = array();
            }
        }

        if ($cases) {
            foreach ($solution_cases as $s_case) {
                $list[] = $cases[$s_case['id']];
            }
        }

        return $list;
    }

    /**
     * _getSolutionApps()
     *   - Get solutions app.
     *
     * @param array $solution
     */
    protected function _getSolutionApps($solution) {

        $solutionsApps = array();
        $model  = $this->getModel(SOLUTION_APP);

        $where = array(
            'solution' => $solution,
        );

        $select = $model->select()->order(array('id DESC'));
        $select->where($where);
        $rowset = $model->selectWith($select);

        foreach ($rowset as $row) {
            $app = $row->toArray();
            $solutionsApps[$app['app']] = $app;
        }

        return $solutionsApps;
    }

}
