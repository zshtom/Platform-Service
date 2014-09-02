<?php
namespace Module\Apps\Installer\Resource;

use Pi;
use Pi\Application\Installer\Resource\Page as BasicPage;

class Apps extends BasicPage
{
    /**
     * Overwrite regular page updater to avoid page deletion
     *
     * @return bool
     */
    public function updateAction()
    {
        $module = $this->event->getParam('module');
        Pi::registry('apps')->clear($module);

        return true;
    }
}
