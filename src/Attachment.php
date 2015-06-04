<?php
/**
 * Created by PhpStorm.
 * User: ck4m
 * Date: 6/4/15
 * Time: 10:54
 */

namespace Hyperdigital\RawEmail;

/**
 * Class Attachment
 * @package Hyperdigital\RawEmail
 *
 * Encapsulates data that is required by a single
 * email attachment.
 *
 * The attachment body MUST be encoded with Base64
 */
class Attachment {
    /** @var string $name */
    private $name;

    /** @var string $contentType */
    private $contentType;

    /** @var string $body */
    private $body;

    /**
     * @param string $name
     * @param string $contentType
     * @param string $body Base64 encoded data
     */
    public function __construct($name, $contentType, $body) {
        $this->name = $name;
        $this->contentType = $contentType;
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getContentType() {
        return $this->contentType;
    }

    /**
     * @return string
     */
    public function getBody() {
        return $this->body;
    }
}