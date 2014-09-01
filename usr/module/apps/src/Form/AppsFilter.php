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
use Module\Apps\Validator;
use Zend\InputFilter\InputFilter;

class AppsFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'          => 'title',
            'filters'       => array(
                array(
                    'name'  => 'StringTrim',
                ),
            ),
        ));

        $this->add(array(
            'name'          => 'nav_order',
            'required'      => false,
            'filters'       => array(
                array(
                    'name'  => 'StringTrim',
                ),
            ),
        ));

        $this->add(array(
            'name'          => 'name',
            'required'      => false,
            'filters'       => array(
                array(
                    'name'  => 'StringTrim',
                ),
            ),
            'validators'    => array(
                array(
                    'name'      => 'Regex',
                    'options'   => array(
                        'pattern'   => '/[a-z0-9_]/',
                    ),
                ),
                new Validator\AppsNameDuplicate(),
            ),
        ));

        $this->add(array(
            'name'          => 'summery',
            'required'      => false,
            'filters'       => array(
                array(
                    'name'  => 'StringTrim',
                ),
            ),
        ));

        $this->add(array(
            'name'          => 'icon',
            'required'      => false,
            'filters'       => array(
                array(
                    'name'  => 'StringTrim',
                ),
            ),
        ));

        $this->add(array(
            'name'          => 'slug',
            'required'      => false,
            'filters'       => array(
                array(
                    'name'  => 'StringTrim',
                ),
            ),
            'validators'    => array(
                new Validator\AppsSlugDuplicate(),
            ),
        ));

        $this->add(array(
            'name'          => 'markup',
            'filters'       => array(
                array(
                    'name'  => 'StringTrim',
                ),
            ),
        ));

        $this->add(array(
            'name'          => 'active',
        ));

        $this->add(array(
            'name'          => 'theme',
            'required'      => false,
        ));

        $this->add(array(
            'name'          => 'layout',
            'required'      => false,
        ));

        $this->add(array(
            'name'          => 'content',
            'filters'       => array(
                array(
                    'name'  => 'StringTrim',
                ),
            ),
            'validators'    => array(
                new Validator\AppsTemplateAvailable(),
            ),
        ));

        $this->add(array(
            'name'          => 'id',
            'required'      => false,
        ));

        // seo_title
        $this->add(array(
            'name' => 'seo_title',
            'required' => false,
        ));

        // seo_keywords
        $this->add(array(
            'name' => 'seo_keywords',
            'required' => false,
        ));

        // seo_description
        $this->add(array(
            'name' => 'seo_description',
            'required' => false,
        ));
    }
}
