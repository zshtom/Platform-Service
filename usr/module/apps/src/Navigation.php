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
    public static function front()
    {
        $nav = array(
            'parent' => array(),
        );

        $nav['parent']['nav-home'] = array(
            'order'         => -100,
            'label'         => __('Nav Home'),
            'route'         => 'home',

            'pages'         => array(
                'account'   => array(
                    'label'         => __('Profile'),
                    'route'         => 'sysuser',
                    'controller'    => 'profile',

                    'pages'         => array(
                        'login'     => array(
                            'label'         => __('Login'),
                            'route'         => 'sysuser',
                            'controller'    => 'login',
                            'visible'       => 0,
                        ),

                        'register'     => array(
                            'label'         => __('Register'),
                            'route'         => 'sysuser',
                            'controller'    => 'register',
                            'visible'       => 0,
                        ),

                        'password'     => array(
                            'label'         => __('Password'),
                            'route'         => 'sysuser',
                            'controller'    => 'password',
                            'visible'       => 0,
                        ),
                    ),
                ),
                'admin'     => array(
                    'label'     => __('Admin Stage'),
                    'route'     => 'home',
                    'section'   => 'admin',
                    'target'    => '_blank',
                ),
                'feed'     => array(
                    'label'     => __('RSS Feed'),
                    'route'     => 'feed',
                    'section'   => 'feed',
                    'target'    => '_blank',
                ),
            ),
        );


        $modules = Pi::registry('modulelist')->read('active');
        unset($modules['system']);
        unset($modules['common']);
        unset($modules['freetrial']);
        unset($modules['search']);
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
            $nav['parent']['apps']['label'] = $modules['apps']['title'];
        }
        if(isset($modules['solution'])){
            $nav['parent']['solution'] = Navigation::solutions();
            $nav['parent']['solution']['label'] = $modules['solution']['title'];
        }
        if(isset($modules['cases'])){
            $nav['parent']['cases'] = Navigation::cases();
            $nav['parent']['cases']['label'] = $modules['cases']['title'];
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
