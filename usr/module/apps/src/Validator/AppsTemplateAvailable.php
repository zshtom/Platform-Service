<?php
namespace Module\Apps\Validator;

use Pi;
use Zend\Validator\AbstractValidator;

class AppsTemplateAvailable extends AbstractValidator
{
    const UNAVAILABLE        = 'templateUnavailable';

    public function __construct()
    {
        $this->messageTemplates = array(
            self::UNAVAILABLE => _a('Template file is not available.'),
        );

        parent::__construct();
    }

    /**
     * Template name validate
     *
     * @param  mixed $value
     * @param  array $context
     * @return boolean
     */
    public function isValid($value, $context = null)
    {
        $this->setValue($value);

        if ('phtml' == $context['markup']) {
            $file = sprintf(
                '%s/module/apps/template/front/%s.phtml',
                Pi::path('custom'),
                $value
            );
            if (!is_readable($file)) {
                $this->error(static::UNAVAILABLE);
                return false;
            }
        }

        return true;
    }
}
