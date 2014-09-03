<?php
namespace Module\Solution\Validator;

use Pi;
use Zend\Validator\AbstractValidator;

class SolutionSlugDuplicate extends AbstractValidator
{
    const TAKEN        = 'slugExists';

    public function __construct()
    {
        $this->messageTemplates = array(
            self::TAKEN => _a('Solution slug already exists.'),
        );

        parent::__construct();
    }

    /**
     * Solution slug validate
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
            $rowset = Pi::model('solution/solution')->select($where);
            if ($rowset->count()) {
                $this->error(static::TAKEN);
                return false;
            }
        }

        return true;
    }
}
