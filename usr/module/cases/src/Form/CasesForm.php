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
use Pi\Form\Form as BaseForm;

class CasesForm extends BaseForm
{

    /**
     * Constructor
     *
     * @param null|string|int $name Optional name for the element
     * @param string $markup Cases type: html
     */
    public function __construct($name = null)
    {
        parent::__construct($name);
    }

    public function getInputFilter()
    {
        if (!$this->filter) {
            $this->filter = new CasesFilter;
        }

        return $this->filter;
    }

    public function init()
    {
        $this->add(array(
            'name'          => 'title',
            'options'       => array(
                'label' => _a('Case title'),
            ),
            'attributes'    => array(
                'type'  => 'text',
            )
        ));

        $this->add(array(
            'name'          => 'order',
            'options'       => array(
                'label' => _a('Order'),
            ),
            'attributes'    => array(
                'type'  => 'text',
            ),
        ));

        $this->add(array(
            'name'          => 'summary',
            'options'       => array(
                'label' => _a('Case Summary'),
            ),
            'attributes'    => array(
                'type'  => 'textarea',
            )
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
            'name'          => 'content',
            'type'          => 'editor',
            'options'       => array(
                'label'     => _a('Case Content'),
                'editor'    => 'html',
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
