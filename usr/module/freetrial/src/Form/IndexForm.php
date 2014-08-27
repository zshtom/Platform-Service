<?php
/**
 * Pi Engine (http://www.social-touch.com/)
 *
 * @link      http://www.social-touch.com/ for the Pi Engine source repository
 * @copyright Copyright (c) Pi Engine (http://www.social-touch.com/)
 */

namespace Module\Freetrial\Form;

use Pi\Form\Form as BaseForm;

/**
 * Feature list:
 * 1.Create Freetrial module forms
 *
 * @author Author Name <[songshixin_songshixin@social-touch.com]>
 */
class IndexForm extends BaseForm
{
    /**
     * Create Freetrial module forms
     */
    public function init()
    {
        $this->add(array(
            'name'          => 'name',
            'options'       => array(
                'label'     => __('Name*'),
            ),
            'attributes'    => array(
                'type'      => 'text',
            ),
        ));

        $this->add(array(
            'name'          => 'title',
            'options'       => array(
                'label'     => __('Title*'),
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
            'name'          => 'email',
            'options'       => array(
                'label'     => __('Email*'),
            ),
            'attributes'    => array(

                'type'      => 'text',
            ),
        ));
        $this->add(array(
            'name'          => 'phone',
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
