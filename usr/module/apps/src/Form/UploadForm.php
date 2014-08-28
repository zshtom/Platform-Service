<?php
// @link http://framework.zend.com/manual/2.1/en/modules/zend.form.file-upload.html
// File: UploadForm.php

namespace Module\Apps\Form;

use Pi;
use Pi\Form\Form as BaseForm;
use Zend\Form\Element;

class UploadForm extends BaseForm
{
public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        $this->addElements();
    }

    public function addElements()
    {
        // File Input
        $file = new Element\File('image-file');
        $file->setLabel('Avatar Image Upload')
             ->setAttribute('id', 'image-file');
        $this->add($file);
    }
}