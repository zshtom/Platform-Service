<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Cases\Form;

use Pi;
use Module\Cases\Validator;
use Zend\InputFilter\InputFilter;

/**
 * Filter and validator of Cases add form
 * 
 * @author chenxiaoliang <chenxiaoliang@social-touch.com>
 */
class CasesFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'          => 'title',
            'filters'       => array(
                array(
                    'name'  => 'StringTrim',
                ),
            ),
        ));

        $this->add(array(
            'name'          => 'order',
            'required'      => false,
            'filters'       => array(
                array(
                    'name'  => 'StringTrim',
                ),
            ),
        ));


        $this->add(array(
            'name'          => 'summery',
            'required'      => false,
            'filters'       => array(
                array(
                    'name'  => 'StringTrim',
                ),
            ),
        ));

        $this->add(array(
            'name'          => 'icon',
            'required'      => false,
            'filters'       => array(
                array(
                    'name'  => 'StringTrim',
                ),
            ),
        ));

        $this->add(array(
            'name'          => 'active',
        ));

        $this->add(array(
            'name'          => 'content',
            'filters'       => array(
                array(
                    'name'  => 'StringTrim',
                ),
            ),
        ));

        // seo_title
        $this->add(array(
            'name' => 'seo_title',
            'required' => false,
        ));

        // seo_keywords
        $this->add(array(
            'name' => 'seo_keywords',
            'required' => false,
        ));

        // seo_description
        $this->add(array(
            'name' => 'seo_description',
            'required' => false,
        ));
        
        $this->add(array(
            'name'     => 'id',
            'required' => false,
        ));
    }
}
