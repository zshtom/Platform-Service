<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Solution\Form;

use Pi;
// use Module\Solution\Validator;
use Zend\InputFilter\InputFilter;

class DescFilter extends InputFilter
{
    public function __construct()
    {


        $this->add(array(
            'name'          => 'description',
            'filters'       => array(
                array(
                    'name'  => 'StringTrim',
                ),
            ),
        ));


    }
}
