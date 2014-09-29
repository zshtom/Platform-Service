<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Apps;

use Pi;

class Navigation
{
    public static function front($module)
    {
        $nav = array(
            'parent' => array(),
        );

        $modules = Pi::registry('modulelist')->read('active');
        unset($modules['system']);
        unset($modules['common']);
        foreach ($modules as $key => $data) {
            $node = Pi::registry('navigation')->read($key.'-front');
            if (!is_array($node)) {
                continue;
            }

            $nav['parent'][$key] = array(
                'label'     => $data['title'],
                'route'     => 'default',
                'module'    => $key,
                'pages'     => $node,
            );
        }
        if(isset($modules['apps'])){
            $nav['parent']['apps'] = Navigation::apps();
        }
        if(isset($modules['solution'])){
            $nav['parent']['solution'] = Navigation::solutions();
        }
        if(isset($modules['cases'])){
            $nav['parent']['cases'] = Navigation::cases();
        }
        if (empty($nav['parent'])) {
            $nav['visible'] = 0;
        }

        return $nav;
    }
    public static function apps($module)
    {
        $nav = array(
            'pages'     => array(),
            'route'     => 'default',
            'module'    => 'apps',
            'label'     => __('Apps'),
        );

        $nav_list = array();

        try {
            $nav_list = Pi::api('api', 'apps')->getAppsList(1);
        } catch (\Exception $exception) {
            return false;
        }

        foreach ($nav_list as $key => $data) {
            $nav['pages'][$key] = array(
                'label'     => $data['title'],
                'module'    => 'apps',
                'uri'     => Pi::url('').$data['url'],
            );
        }

        return $nav;

    }

    /**
     * @TODO Move it to solution module?
     * solutionList()
     *   - Try get solution list for nav from solution module.
     *
     * @param string $module
     *   - Current module name.
     *
     * @return array
     *   - <multitype:multitype: , multitype:string unknown >
     */
    public static function solutions($module)
    {
        $nav = array(
            'pages'     => array(),
            'route'     => 'default',
            'module'    => 'solution',
            'label'     => __('Solution'),
        );

        $nav_list = array();

        // Get the nav from list because active not set in registry.
        try {
//             $nav_list  = Pi::api('api')->solution->getSolutionList();
            $nav_list = Pi::api('api', 'solution')->getSolutionList(1);
        } catch (\Exception $exception) {
            return false;
        }

        foreach ($nav_list as $key => $data) {
            $nav['pages'][$key] = array(
                'label'     => $data['title'],
                'module'    => 'solution',
                'uri'     => Pi::url('').$data['url'],
            );
        }

        return $nav;
    }

    public static function cases($module)
    {
        $nav = array(
            'pages'     => array(),
            'route'     => 'default',
            'module'    => 'cases',
            'label'     => __('Cases'),
        );

        $nav_list = array();

        try {
            $nav_list = Pi::api('api', 'cases')->caseList();
        } catch (\Exception $exception) {
            return false;
        }

        foreach ($nav_list as $key => $data) {
            $nav['pages'][$key] = array(
                'label'     => $data['title'],
                'module'    => 'cases',
                'uri'     => Pi::url('').$data['url'],
            );
        }

        return $nav;
    }
}
