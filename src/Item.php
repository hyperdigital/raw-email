<?php
/**
 * Created by PhpStorm.
 * User: ck4m
 * Date: 6/4/15
 * Time: 14:36
 */

namespace Hyperdigital\RawEmail;


require_once __DIR__.'/../vendor/autoload.php';

/**
 * Class Item
 * @package Hyperdigital\RawEmail
 *
 * Represents a single e-mail item. One attachment for instance.
 * Each item has multiple fields (definitions), such as Content-Type.
 * All the fields have one value assigned, for example attachment's base64 data.
 */
class Item {
    /** @var Field[] $fields */
    private $fields;

    /** @var string $value */
    private $value;

    /**
     * @param Field $field
     */
    public function addField(Field $field) {
        $this->fields[] = $field;
    }

    /**
     * @param $value
     */
    public function setValue($value) {
        $this->value = $value;
    }

    /**
     * @return Field[]
     */
    public function getFields() {
        return $this->fields;
    }

    /**
     * @return string
     */
    public function getValue() {
        return $this->value;
    }
}