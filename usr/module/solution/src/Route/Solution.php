<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Solution\Route;

use Pi;
use Pi\Mvc\Router\Http\Standard;

/**
 * Route for solution
 *
 *  1. ID: /url/solution/123
 *  2. Slug: /url/solution/my-slug
 *  3. Name: /url/solution/myname
 */
class Solution extends Standard
{
    /**
     * {@inheritDoc}
     */
    public function parse($path)
    {
        $module = $this->defaults['module'];
        $name = '';
        if ($path) {
            if (false !== ($pos = strpos($path, $this->paramDelimiter))) {
                list($name, $path) = explode($this->paramDelimiter, $path, 2);
            } else {
                $name = $path;
                $path = '';
            }
        }

        $params  = $path
            ? explode($this->paramDelimiter, trim($path, $this->paramDelimiter))
            : array();
        $params = parent::parseParams($params);
        $matches = array_merge($this->defaults, $params);

        // Set id
        if (is_numeric($name)) {
            $matches['id'] = (int) $name;
            $name = '';
        // Set name
        } else {
            $name = $this->decode($name);
        }

        // Set action
        $action = '';
        $solutionsList  = Pi::api('api', $module)->getSolutionList();

        if (!empty($matches['id'])) {
            if (isset($solutionsList[$matches['id']])) {
                $action = $solutionsList[$matches['id']]['name'];
            }
        } else {
            $pName = empty($matches['name']) ? $name : $matches['name'];
            $pSlug = empty($matches['slug']) ? $name : $matches['slug'];

            if ($pName || $pSlug) {
                foreach ($solutionsList as $id => $solution) {
                    if ($pName && $pName == $solution['name']) {
                        $action = $solution['name'];
                        $matches['id'] = $id;
                        break;
                    }
                    if ($pSlug && $pSlug == $solution['slug']) {
                        $action = $solution['name'];
                        $matches['id'] = $id;
                        break;
                    }
                }
            }
        }
        if ($action) {
            $matches['action'] = $action;
        }

        return $matches;
    }

    /**
     * {@inheritDoc}
     */
    public function assemble(array $params = array(), array $options = array())
    {
        //$this->prefix = $this->defaults['module'];

        $mergedParams = array_merge($this->defaults, $params);
        $url = '';
        if (!empty($mergedParams['slug'])) {
            $url = $this->encode($mergedParams['slug']);
        } elseif (!empty($mergedParams['name'])) {
            $url = $this->encode($mergedParams['name']);
        } elseif (!empty($mergedParams['id'])) {
            $url = (int) $mergedParams['id'];
        }
        if (empty($url)) {
            return $this->prefix;
        }
        $params = array();
        $prefix = $this->prefix;
        $this->prefix .= $this->paramDelimiter . $url;
        $url = parent::assemble($params, $options);
        $this->prefix = $prefix;

        return $url;
    }
}
