<?php

namespace EvaluationBundle\Entity;

use GlobalBundle\Exception\InvalidEntityFormException;

/**
 * Class InvalidDiplomeFormException
 * @package SchoolBundle\Entity
 */
class InvalidEvaluationIntervenantFormException extends InvalidEntityFormException
{

    /**
     * @param string $message
     * @param null $form
     */
    public function __construct($message, $form = null)
    {
        parent::__construct($message, $form);
    }

}