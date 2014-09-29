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
        unset($modules['freetrial']);
        foreach ($modules as $key => $data) {
            $node = Pi::registry('navigation')->read($key.'-front');
            if (!is_array($node)) {
                continue;
            }

            $nav['parent'][$key] = array(
                'label'     => $data['title'],
                'route'     => 'default',
                'module'    => $key,
                'uri'       => Pi::url('').'/'.$key,
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
    public static function apps()
    {
        $nav = array(
            'pages'     => array(),
            'route'     => 'default',
            'module'    => 'apps',
            'label'     => __('Apps'),
            'uri'       =>  Pi::url('').'/apps/',
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
                'uri'     => $data['url'],
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
    public static function solutions()
    {
        $nav = array(
            'pages'     => array(),
            'route'     => 'default',
            'module'    => 'solution',
            'label'     => __('Solution'),
            'uri'       => Pi::url('').'/solution/',
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
                'uri'     => $data['url'],
            );
        }

        return $nav;
    }

    public static function cases()
    {
        $nav = array(
            'pages'     => array(),
            'route'     => 'default',
            'module'    => 'cases',
            'label'     => __('Cases'),
            'uri'       => Pi::url('').'/cases/',
        );

        $nav_list = array();

        try {
            $nav_list = Pi::api('api', 'cases')->caseList();
        } catch (\Exception $exception) {
            return false;
        }

        foreach ($nav_list as $key => $data) {
            $nav['pages'][] = array(
                'label'     => $data['title'],
                'module'    => 'cases',
                'uri'       => Pi::url('').'/cases/index/detail/id-'.$data['id'],
            );
        }
        return $nav;
    }
}
