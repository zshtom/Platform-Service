<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Zto\Form;
use Pi;
use Pi\Form\Form as BaseForm;

class ContactForm extends BaseForm
{
    public function getInputFilter()
    {

        if (!$this->filter) {
            $this->filter = new ContactFilter;
        }

        return $this->filter;

    }

    public function init()
    {

        //d(Pi::config('', 'zto'));
        $config = Pi::config('', 'zto');

        if($config['company'] == 1){
            $this->add(array(
                'name'          => 'company',
                'options'       => array(
                    'label' => __('公司名称'),
                ),
                'type'  => 'text',
            ));
        }

        if($config['phone'] == 1){
            $this->add(array(
                'name'          => 'phone',
                'options'       => array(
                    'label' => __('联系方式'),
                ),
                'type'  => 'text',
            ));
        }

        if($config['email'] == 1){
            $this->add(array(
                'name'          => 'email',
                'options'       => array(
                    'label' => __('email'),
                ),
                'type'  => 'text',
            ));
        }

        if($config['address'] == 1){
            $this->add(array(
                'name'          => 'address',
                'options'       => array(
                    'label' => __('地址'),
                ),
                'type'  => 'textarea',
                /*
                'attributes'    => array(
                    'rows'  => 3,   // default value
                ),
                */
                'required' => true,
            ));
        }

        $this->add(array(
            'name'          => 'submit',
            'type'          => 'submit',
            'attributes'    => array(
                'value' => __('Submit'),
                'class' => 'btn btn-primary'
            )
        ));
    }
}
