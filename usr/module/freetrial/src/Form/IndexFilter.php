<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14-8-19
 * Time: 下午5:25
 */
namespace Module\Freetrial\Form;

use Zend\InputFilter\InputFilter;

class IndexFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'          => 'username',
            'options'       => array(
<<<<<<< HEAD
                'label'     => __('name*'),
=======
                'label'     => __('Name'),
>>>>>>> 7648b317fb2872603b4af2e3b31007475aa04339
            ),
            'attributes'    => array(

                'type'      => 'text',
            ),
        ));

        $this->add(array(
            'name'          => 'work',
            'options'       => array(
<<<<<<< HEAD
                'label'     => __('title*'),
=======
                'label'     => __('Title*'),
>>>>>>> 7648b317fb2872603b4af2e3b31007475aa04339
            ),
            'attributes'    => array(

                'type'      => 'text',
            ),
        ));
        $this->add(array(
            'name'          => 'company',
            'options'       => array(
<<<<<<< HEAD
                'label'     => __('company*'),
=======
                'label'     => __('Company*'),
>>>>>>> 7648b317fb2872603b4af2e3b31007475aa04339
            ),
            'attributes'    => array(

                'type'      => 'text',
            ),
        ));
        $this->add(array(
            'name'          => 'comp_mail',
            'options'       => array(
<<<<<<< HEAD
                'label'     => __('email*'),
=======
                'label'     => __('Email*'),
>>>>>>> 7648b317fb2872603b4af2e3b31007475aa04339
            ),
            'attributes'    => array(

                'type'      => 'text',
            ),
        ));
        $this->add(array(
            'name'          => 'phonenum',
            'options'       => array(
<<<<<<< HEAD
                'label'     => __('phone*'),
=======
                'label'     => __('Phone*'),
>>>>>>> 7648b317fb2872603b4af2e3b31007475aa04339
            ),
            'attributes'    => array(

                'type'      => 'text',
            ),
        ));
        $this->add(array(
            'name'          => 'submit',
            'attributes'    => array(
<<<<<<< HEAD
                'value'     => __('freetrial'),
=======
                'value'     => __('Freetrial'),
>>>>>>> 7648b317fb2872603b4af2e3b31007475aa04339
                'type'          => 'submit',
            ),

        ));
    }
}
