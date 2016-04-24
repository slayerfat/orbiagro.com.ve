<?php namespace Orbiagro\Mamarrachismo\Upload\Exceptions;

use Exception;

class ImageValidationFail extends Exception
{
    /**
     * @var array
     */
    protected $errors;

    /**
     * ImageValidationFail constructor.
     *
     * @param string $message
     * @param array $errors
     */
    public function __construct($message, $errors)
    {
        $this->errors = $errors;

        parent::__construct($message);
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }
}