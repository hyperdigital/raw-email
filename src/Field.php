<?php
/**
 * Created by PhpStorm.
 * User: ck4m
 * Date: 6/4/15
 * Time: 15:01
 */

namespace Hyperdigital\RawEmail;

/**
 * Class Field
 * @package Hyperdigital\RawEmail
 *
 * Represents a single email field. For example
 * Content-Type: text/html; charset=UTF-8 would be written as:
 * new Field(Field::CONTENT_TYPE, array('text/html', 'charset=UTF-8'))
 *
 * The resulting string may be retrieved using getFormattedString()
 */
class Field {
    const RETURN_PATH = 'Return-Path';
    const FROM = 'From';
    const TO = 'To';
    const SUBJECT = 'Subject';
    const MIME_VERSION = 'MIME-Version';

    const CONTENT_TRANSFER_ENCODING = 'Content-Transfer-Encoding';
    const CONTENT_TYPE = 'Content-Type';
    const CONTENT_DISPOSITION = 'Content-Disposition';

    /** @var string $name */
    private $name;

    /** @var mixed[] $parameters */
    private $parameters;

    /**
     * @param string $name
     * @param mixed[] $parameters
     */
    public function __construct($name, array $parameters) {
        $this->name = $name;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return array|\mixed[]
     */
    public function getParameters() {
        return $this->parameters;
    }

    /**
     * Returns mail-compliant string
     *
     * @return string
     */
    public function getFormattedString() {
        $params = join('; ', $this->parameters);
        return "{$this->name}: $params\n";
    }
}