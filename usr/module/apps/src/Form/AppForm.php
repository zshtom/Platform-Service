<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Apps\Form;

use Pi;
use Pi\Form\Form as BaseForm;

class AppForm extends BaseForm
{
    protected $markup = 'html';

    /**
     * Constructor
     *
     * @param null|string|int $name Optional name for the element
     * @param string $markup App type: text, html, markdown
     */
    public function __construct($name = null, $markup = null)
    {
        $this->markup = $markup ?: $this->markup;
        parent::__construct($name);
    }

    public function getInputFilter()
    {
        if (!$this->filter) {
            $this->filter = new AppFilter;
        }

        return $this->filter;
    }

    public function init()
    {
        $this->add(array(
            'name'          => 'title',
            'options'       => array(
                'label' => _a('App title'),
            ),
            'attributes'    => array(
                'type'  => 'text',
            )
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
            'name'          => 'time_release',
            'options'       => array(
                    'label' => _a('Release Time'),
            ),
            'attributes'    => array(
                    'type'  => 'text',
                    'description'   => _a(''),
            ),
        ));

        $this->add(array(
            'name'          => 'summery',
            'options'       => array(
                    'label' => _a('Summery'),
            ),
            'attributes'    => array(
                    'type'  => 'textarea',
                    'description'   => _a('255 Charts limit.'),
            ),
        ));

        $set = '';
        switch ($this->markup) {
            case 'html':
                $editor         = 'html';
                break;
            case 'markdown':
                $editor         = 'markitup';
                $set            = 'markdown';
                break;
            case 'text':
            default:
                $editor         = 'textarea';
                break;
        }

        $this->add(array(
            'name'          => 'content',
            'type'          => 'editor',
            'options'       => array(
                'label'     => _a('Content'),
                'editor'    => $editor,
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
            'name'          => 'markup',
            'attributes'    => array(
                'type'  => 'hidden',
                'value' => $this->markup,
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
