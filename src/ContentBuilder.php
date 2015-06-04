<?php
/**
 * Created by PhpStorm.
 * User: ck4m
 * Date: 6/4/15
 * Time: 14:25
 */

namespace Hyperdigital\RawEmail;


require_once __DIR__.'/../vendor/autoload.php';

/**
 * Class ContentBuilder
 * @package Hyperdigital\RawEmail
 *
 * This class builds the content of an arbitrary raw email.
 * It's using Item and Boundary classes for that purpose.
 * The main benefit is that you don't need to take care
 * of the proper line breaking that email format requires.
 */
class ContentBuilder {
    /** @var string $output */
    private $output = '';

    /**
     * @param Item $item
     */
    public function insertItem(Item $item) {
        foreach ($item->getFields() as $field) {
            $this->output .= $field->getFormattedString();
        }

        $this->output .= "\n";

        if (!is_null($item->getValue())) {
            $this->output .= $item->getValue();
        }

        $this->output .= "\n";
    }

    /**
     * @param Boundary $boundary
     */
    public function insertBoundary(Boundary $boundary) {
        $this->output .= $boundary->getFormattedUse();
    }

    /**
     * @param Boundary $boundary
     */
    public function closeBoundary(Boundary $boundary) {
        $this->output .= $boundary->getFormattedClose();
    }

    /**
     * @return string
     */
    public function getOutput() {
        return $this->output;
    }
}