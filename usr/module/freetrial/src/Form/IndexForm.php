<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14-8-19
 * Time: 下午5:25
 */
namespace Module\Freetrial\Form;
use Pi\Form\Form as BaseForm;

class IndexForm extends BaseForm
{
    public function init()
    {
        $this->add(array(
            'name'          => 'username',
            'options'       => array(
                'label'     => __('Name'),
            ),
            'attributes'    => array(

                'type'      => 'text',
            ),
        ));

        $this->add(array(
            'name'          => 'work',
            'options'       => array(
                'label'     => __('Title'),
            ),
            'attributes'    => array(

                'type'      => 'text',
            ),
        ));
        $this->add(array(
            'name'          => 'company',
            'options'       => array(
                'label'     => __('Company*'),
            ),
            'attributes'    => array(

                'type'      => 'text',
            ),
        ));
        $this->add(array(
            'name'          => 'comp_mail',
            'options'       => array(
                'label'     => __('Email*'),
            ),
            'attributes'    => array(

                'type'      => 'text',
            ),
        ));
        $this->add(array(
            'name'          => 'phonenum',
            'options'       => array(
                'label'     => __('Phone*'),
            ),
            'attributes'    => array(

                'type'      => 'text',
            ),
        ));
        $this->add(array(
            'name'          => 'submit',
            'attributes'    => array(
                'value'     => __('Freetrial'),
            ),
            'type'          => 'submit',
        ));



    }

}