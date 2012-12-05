<?php
/**
 * Pi Engine Editor Default
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Copyright (c) Pi Engine http://www.xoopsengine.org
 * @license         http://www.xoopsengine.org/license New BSD License
 * @author          Taiwen Jiang <taiwenjiang@tsinghua.org.cn>
 * @since           3.0
 * @package         Pi\Editor
 * @version         $Id$
 */


namespace Pi\Editor\Pi;

use Pi\Editor\AbstractRenderer;
//use Zend\View\Renderer\RendererInterface as Renderer;
use Zend\Form\ElementInterface;

class Renderer extends AbstractRenderer
{
    /**
     * Renders editor contents
     *
     * @param  ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element)
    {
        return $this->view->formTextarea($element);
    }
}
