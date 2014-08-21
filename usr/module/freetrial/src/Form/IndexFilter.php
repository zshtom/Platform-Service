<?php
/**
 * Pi Engine (http://www.social-touch.com/)
 *
 * @link      http://www.social-touch.com/ for the Pi Engine source repository
 * @copyright Copyright (c) Pi Engine (http://www.social-touch.com/)
 */
namespace Module\Freetrial\Form;

use Zend\InputFilter\InputFilter;

/**
 * Feature list:
 * 1.Filter file
 *
 * @author Author Name <[songshixin_songshixin@social-touch.com]>
 */
class IndexFilter extends InputFilter
{
    /**
     * Filter file
     */
    public function __construct()
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
                'type'          => 'submit',
            ),
        ));
    }
}