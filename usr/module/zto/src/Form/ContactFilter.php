<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Zto\Form;

use Zend\InputFilter\InputFilter;

class ContactFilter extends InputFilter
{
    public function __construct()
   {
       $this->add(array(
           'name'        => 'company',
           'required'    => true,
           'filters'     => array(
               array(
                   'name'    => 'StringTrim',
               ),
           ),
           'validators'  => array(
               array(
                   'name'    => 'StringLength',
                   'options' => array(
                       'min'     => 5,
                       'max'     => 25,
                   ),
               ),
           ),
       ));

       $this->add(array(
           'name'          => 'phone',
           'filters'       => array(
               array(
                   'name'  => 'StringTrim',
               ),
           ),
       ));
       $this->add(array(
          'name'          => 'email',
          'filters'       => array(
              array(
                  'name'  => 'StringTrim',
              ),
          ),
      ));
      $this->add(array(
         'name'          => 'address',
         'filters'       => array(
             array(
                 'name'  => 'StringTrim',
             ),
         ),
     ));
   }
}
