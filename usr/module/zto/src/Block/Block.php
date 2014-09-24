<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\zto\Block;
use Pi;

class Block
{
    public static function blocka($options, $module = null)
    {
        $block = array(
            'caption'   => _b('Block A '),
            'content'   => _b("this is my first block,I think it's best! haha!"),
            'options'   => $options,
        );
        return $block;
    }
}
