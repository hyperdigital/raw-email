<?php
/**
 * Created by PhpStorm.
 * User: ck4m
 * Date: 6/4/15
 * Time: 15:12
 */

namespace Hyperdigital\RawEmail;

/**
 * Class Boundary
 * @package Hyperdigital\RawEmail
 *
 * Represents a single email boundary, also
 * allows you to generate one.
 */
class Boundary {
    /** @var string $boundary */
    private $boundary;

    /**
     * @param string $boundary
     */
    public function __construct($boundary) {
        $this->boundary = $boundary;
    }

    /**
     * @return string
     */
    public function getBoundary() {
        return $this->boundary;
    }

    /**
     * @return string
     */
    public function getFormattedUse() {
        return "--{$this->boundary}\n";
    }

    /**
     * @return string
     */
    public function getFormattedClose() {
        return "\n--{$this->boundary}--\n";
    }

    /**
     * @return string
     */
    public static function generate() {
        return md5(uniqid(time()));
    }
}