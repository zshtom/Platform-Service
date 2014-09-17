<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14-7-24
 * Time: 下午4:19
 */

namespace Module\Resource\Form;

use Zend\InputFilter\InputFilter;
use Zend\Form;



class BootstrapFilter extends InputFilter
{
    public function __construct()
    {
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
            'name'          => 'sid',
            'filters'       => array(
                array(
                    'name'  => 'StringTrim',
                ),
            ),
        ));

        $this->add(array(
            'name'        => 'title',
            'required'    => true,
            'filters'     => array(
                array(
                    'name'    => 'StringTrim',
                ),
            ),
            'validators'  => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min'     => 5,
                        'max'     => 25,
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name'          => 'description',
            'attributes'    => array(
                'type'  => 'textarea',
                'cols'  => '50',
                'rows'  => '10',
            ),
            'options'       => array(
                'label' => __('Your details'),
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