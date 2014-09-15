<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Resource\Form;

use Pi;
use Pi\Form\Form as BaseForm;

class BootstrapForm extends BaseForm
{
    public function getInputFilter()
    {
        if (!$this->filter) {
            $this->filter = new BootstrapFilter;
        }

        return $this->filter;
    }

    public function init()
    {
        $this->add(array(
            'name'       =>'icon',
            'options'   =>array(
                'lable' =>_a('Icon file name'),
            ),
            'attributes'    =>array(
                'type'    => 'hidden',
                'id'      => 'icon-url'
    )
        ));

        $this->add(array(
            'name'          => 'title',
            'options'       => array(
                'label' => __('Title'),
            ),
            'type'  => 'text',
        ));

        $this->add(array(
            'name'          => 'sid',
            'options'       => array(
                'label' => __('Sort'),
            ),
            'type'  => 'text',
        ));

        $this->add(array(
            'name'          => 'description',
            'options'       => array(
                'label' => __('Description'),
            ),
            'type'  => 'textarea',
            /*
            'attributes'    => array(
                'rows'  => 3,   // default value
            ),
            */
            'required' => true,
        ));

        $this->add(array(
            'name'          => 'upload',
            'options'       => array(
                'label' => __('File'),
            ),
            'type'  => 'file',
        ));

        $this->add(array(
            'name'          => 'case_time',
            'attributes'    => array(
                'type'  => 'hidden',
                'value' => time(),
            )
        ));

        $this->add(array(
            'name'          => 'id',
            'attributes'    => array(
                'type'  => 'hidden',
                'value' => 0,
            )
        ));

        $this->add(array(
            'name'          => 'module',
            'attributes'    => array(
                'type'  => 'hidden',
                'value' => '',
            )
        ));

        $this->add(array(
            'name'          => 'section',
            'attributes'    => array(
                'type'  => 'hidden',
                'value' => 'front',
            )
        ));

        $this->add(array(
            'name'          => 'submit',
            'type'          => 'submit',
            'attributes'    => array(
                'value' => __('Submit'),
                'class' => 'btn btn-primary'
            )
        ));

        //seo
        $this->add(array(
            'name' => 'extra_seo',
            'type' => 'fieldset',
            'options' => array(
                'label' => __('SEO settings'),
            ),
        ));

        // seo_title
        $this->add(array(
            'name' => 'seo_title',
            'options' => array(
                'label' => __('SEO Title'),
            ),
            'attributes' => array(
                'type'          => 'text',
                'description'   => _a('To be used for HTML head meta.'),
            )
        ));

        // seo_keywords
        $this->add(array(
            'name' => 'seo_keywords',
            'options' => array(
                'label' => __('SEO Keywords'),
            ),
            'attributes' => array(
                'type'          => 'text',
                'description'   => _a('To be used for HTML head meta.'),
            )
        ));

        // seo_description
        $this->add(array(
            'name' => 'seo_description',
            'options' => array(
                'label' => __('SEO Description'),
            ),
            'attributes' => array(
                'type'          => 'text',
                'description'   => _a('To be used for HTML head meta.'),
            )
        ));
    }
}
