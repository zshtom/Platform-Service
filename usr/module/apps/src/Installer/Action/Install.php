<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Apps\Installer\Action;

use Pi;
use Pi\Application\Installer\Action\Install as BasicInstall;
use Zend\EventManager\Event;

class Install extends BasicInstall
{
    protected function attachDefaultListeners()
    {
        $events = $this->events;
        $events->attach('install.post', array($this, 'postInstall'), 1);
        parent::attachDefaultListeners();
        return $this;
    }

    /**
     * Pre-install pages for: Terms of service, Privacy,
     * About us, Contact us, Join us, Help, Sitemap
     *
     * @param Event $e
     */
    public function postInstall(Event $e)
    {
        $module = $e->getParam('module');
        $apiHandler = Pi::api('api', 'page')->setModule($module);

        $result = array(
                'status'    => true,
                'message'   => _a('Pages added.'),
        );
        $this->setResult('post-install', $result);
    }

}
