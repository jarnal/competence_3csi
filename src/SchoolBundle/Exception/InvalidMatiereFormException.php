<?php

namespace SchoolBundle\Entity;

use GlobalBundle\Exception\InvalidEntityFormException;

/**
 * Class InvalidDiplomeFormException
 * @package SchoolBundle\Entity
 */
class InvalidMatiereFormException extends InvalidEntityFormException
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