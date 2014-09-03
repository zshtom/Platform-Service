<?php
namespace Module\Solution\Installer\Resource;

use Pi;
use Pi\Application\Installer\Resource\Page as BasicPage;

class Solution extends BasicPage
{
    /**
     * Overwrite regular page updater to avoid page deletion
     *
     * @return bool
     */
    public function updateAction()
    {
        $module = $this->event->getParam('module');
        Pi::registry('solution')->clear($module);

        return true;
    }
}
