<?php
namespace Module\Apps\Validator;

use Pi;
use Zend\Validator\AbstractValidator;

class AppsSlugDuplicate extends AbstractValidator
{
    const TAKEN        = 'slugExists';

    public function __construct()
    {
        $this->messageTemplates = array(
            self::TAKEN => _a('App slug already exists.'),
        );

        parent::__construct();
    }

    /**
     * App slug validate
     *
     * @param  mixed $value
     * @param  array $context
     * @return boolean
     */
    public function isValid($value, $context = null)
    {
        $this->setValue($value);

        if (null !== $value) {
            $where = array('slug' => $value);
            if (!empty($context['id'])) {
                $where['id <> ?'] = $context['id'];
            }
            $rowset = Pi::model('apps/apps')->select($where);
            if ($rowset->count()) {
                $this->error(static::TAKEN);
                return false;
            }
        }

        return true;
    }
}
