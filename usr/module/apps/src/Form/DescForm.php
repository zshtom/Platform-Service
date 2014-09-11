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

class DescForm extends BaseForm
{
    protected $markup = 'html';

    /**
     * Constructor
     *
     * @param null|string|int $name Optional name for the element
     * @param string $markup Apps type: html
     */
    public function __construct($name = null, $markup = null)
    {
        $this->markup = $markup ?: $this->markup;
        parent::__construct($name);
    }

    public function getInputFilter()
    {
        if (!$this->filter) {
            $this->filter = new DescFilter;
        }

        return $this->filter;
    }

    public function init()
    {

        $set = '';

        $this->add(array(
            'name'          => 'description',
            'type'          => 'editor',
            'options'       => array(
                'label'     => _a('Apps Description'),
                'editor'    => 'html',
                'set'       => $set,
            ),
            'attributes'    => array(
                'rows'         => 5,
            ),
        ));

        $this->add(array(
            'name'          => 'id',
            'attributes'    => array(
                'type'  => 'hidden',
                'value' => 'apps_description',
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
