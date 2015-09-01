<?php namespace Orbiagro\Mamarrachismo\Upload\Exceptions;

use Exception;

class OrphanImageException extends Exception
{

    /**
     * @var null
     */
    private $imageId;

    /**
     * @link http://php.net/manual/en/exception.construct.php
     * @param string $message [optional] The Exception message to throw.
     * @param null $imageId
     */
    public function __construct($message = "", $imageId = null)
    {
        parent::__construct($message);
        $this->imageId = $imageId;
    }

    /**
     * @return null
     */
    public function getImageId()
    {
        return $this->imageId;
    }

    /**
     * @param null $imageId
     */
    public function setImageId($imageId)
    {
        $this->imageId = $imageId;
    }
}
