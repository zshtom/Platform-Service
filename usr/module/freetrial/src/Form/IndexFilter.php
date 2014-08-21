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
                'label'     => __('Name'),
=======
                'label'     => __('name*'),
>>>>>>> upstream/master
            ),
            'attributes'    => array(

                'type'      => 'text',
            ),
        ));

        $this->add(array(
            'name'          => 'work',
            'options'       => array(
<<<<<<< HEAD
                'label'     => __('Title*'),
=======
                'label'     => __('title*'),
>>>>>>> upstream/master
            ),
            'attributes'    => array(

                'type'      => 'text',
            ),
        ));
        $this->add(array(
            'name'          => 'company',
            'options'       => array(
<<<<<<< HEAD
                'label'     => __('Company*'),
=======
                'label'     => __('company*'),
>>>>>>> upstream/master
            ),
            'attributes'    => array(

                'type'      => 'text',
            ),
        ));
        $this->add(array(
            'name'          => 'comp_mail',
            'options'       => array(
<<<<<<< HEAD
                'label'     => __('Email*'),
=======
                'label'     => __('email*'),
>>>>>>> upstream/master
            ),
            'attributes'    => array(

                'type'      => 'text',
            ),
        ));
        $this->add(array(
            'name'          => 'phonenum',
            'options'       => array(
<<<<<<< HEAD
                'label'     => __('Phone*'),
=======
                'label'     => __('phone*'),
>>>>>>> upstream/master
            ),
            'attributes'    => array(

                'type'      => 'text',
            ),
        ));
        $this->add(array(
            'name'          => 'submit',
            'attributes'    => array(
<<<<<<< HEAD
                'value'     => __('Freetrial'),
=======
                'value'     => __('freetrial'),
>>>>>>> upstream/master
                'type'          => 'submit',
            ),

        ));
    }
}
