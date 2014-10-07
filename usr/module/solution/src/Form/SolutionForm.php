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
use Pi\Form\Form as BaseForm;

class SolutionForm extends BaseForm
{
    protected $markup = 'html';

    /**
     * Constructor
     *
     * @param null|string|int $name Optional name for the element
     * @param string $markup Solutions type: html
     */
    public function __construct($name = null, $markup = null)
    {
        $this->markup = $markup ?: $this->markup;
        parent::__construct($name);
    }

    public function getInputFilter()
    {
        if (!$this->filter) {
            $this->filter = new SolutionFilter;
        }

        return $this->filter;
    }

    public function getInputElements(){
        return array('title', 'nav_order', 'name', 'slug', 'summary', 'content');
    }

    public function getSeoElements(){
        return array('seo_title', 'seo_keywords', 'seo_description');
    }

    public function getHiddenElements() {
        return array('id', 'icon');
    }

    public function getCheckboxElements() {
        return array('active');
    }

    public function init()
    {
        $this->add(
            array(
                'name'          => 'title',
                'options'       => array(
                    'label' => _a('Solution Title'),
                ),
                'attributes'    => array(
                    'type'  => 'text',
                )
            )
        );

        $this->add(array(
            'name'          => 'nav_order',
            'options'       => array(
                'label' => _a('Navigation Order'),
            ),
            'attributes'    => array(
                'type'  => 'text',
            ),
        ));

        $this->add(array(
            'name'          => 'name',
            'options'       => array(
                'label' => _a('Unique name'),
            ),
            'attributes'    => array(
                'type'  => 'text',
                'description'   => _a('Only alphabet, number and underscore allowed.'),
            ),
        ));


        $this->add(array(
            'name'          => 'icon',
            'options'       => array(
                'label' => _a('Icon file name.'),
            ),
            'attributes'    => array(
                'type'  => 'hidden',
                'id'    => 'icon-url'
            )
        ));

        $this->add(array(
            'name'          => 'slug',
            'options'       => array(
                'label' => _a('SEO slug'),
            ),
            'attributes'    => array(
                'type'          => 'text',
                'description'   => _a('Unique slug for SEO URL.'),
            )
        ));

        $this->add(array(
            'name'          => 'summary',
            'options'       => array(
                'label' => _a('Solution Summary'),
            ),
            'attributes'    => array(
                'type'  => 'textarea',
            )
        ));


        $set = '';
        $this->add(array(
            'name'          => 'content',
            'type'          => 'editor',
            'options'       => array(
                'label'     => _a('Solution Content'),
                'editor'    => 'html',
                'set'       => $set,
            ),
            'attributes'    => array(
                'rows'         => 5,
            ),
        ));

        // extra_seo
        $this->add(array(
            'name' => 'extra_seo',
            'type' => 'fieldset',
            'options' => array(
                'label' => _a('SEO settings'),
            ),
        ));

        // seo_title
        $this->add(array(
            'name' => 'seo_title',
            'options' => array(
                'label' => _a('SEO Title'),
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
                'label' => _a('SEO Keywords'),
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
                'label' => _a('SEO Description'),
            ),
            'attributes' => array(
                'type'          => 'text',
                'description'   => _a('To be used for HTML head meta.'),
            )
        ));

        // Enable for online
        $this->add(array(
            'name'          => 'active',
            'type'          => 'checkbox',
            'options'       => array(
                'label' => _a('Active'),
            ),
            'attributes'    => array(
                'value'     => '1',
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
            'name'          => 'submit',
            'type'          => 'submit',
            'attributes'    => array(
                'value' => __('Submit'),
            )
        ));
    }
}
