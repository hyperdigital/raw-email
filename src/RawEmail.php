<?php
/**
 * Created by PhpStorm.
 * User: ck4m
 * Date: 6/4/15
 * Time: 10:54
 */

namespace Hyperdigital\RawEmail;


require_once __DIR__.'/../vendor/autoload.php';

class RawEmailException extends \Exception {}

/**
 * Class RawEmail
 * @package Hyperdigital\RawEmail
 *
 * This is the main class of the library. It combines its components,
 * building a raw email based on the given properties.
 */
class RawEmail {
    /** @var string $from */
    private $from;

    /** @var string $returnPath */
    private $returnPath;

    /**
     * @param string $from
     * @param string $returnPath
     */
    public function __construct($from, $returnPath) {
        $this->from = $from;
        $this->returnPath = $returnPath;
    }

    /**
     * Builds a raw email message by the given parameters
     *
     * @param string[] $to The array of recipients
     * @param string $subject The subject of the email
     * @param string $plain The Plain text version of the email
     * @param string $html The HTML version of the email
     * @param Attachment[] $attachments The array of attachments to send
     * @return string The built raw email
     * @throws RawEmailException
     */
    public function build(array $to, $subject, $plain, $html, array $attachments = array())
    {
        if (!self::isPresent($plain) && !self::isPresent($html)) {
            throw new RawEmailException("Either 'plain' or 'html' parameter must be passed");
        }

        $outerBoundary = new Boundary(Boundary::generate());
        $innerBoundary = new Boundary(Boundary::generate());

        $content = new ContentBuilder;

        $basic = new Item();
        $basic->addField(new Field(Field::RETURN_PATH, array($this->returnPath)));
        $basic->addField(new Field(Field::FROM, array($this->from)));
        $basic->addField(new Field(Field::TO, array(join(', ', $to))));
        $basic->addField(new Field(Field::SUBJECT, array($subject)));
        $basic->addField(new Field(Field::MIME_VERSION, array('1.0')));
        $basic->addField(
            new Field(Field::CONTENT_TYPE,
            array('multipart/mixed', "boundary={$outerBoundary->getBoundary()}"))
        );

        $content->insertItem($basic);
        $content->insertBoundary($outerBoundary);

        $message = new Item();
        $message->addField(new Field(
                Field::CONTENT_TYPE,
                array('multipart/alternative', "boundary={$innerBoundary->getBoundary()}"))
        );

        $content->insertItem($message);

        if (self::isPresent($plain)) {
            $content->insertBoundary($innerBoundary);

            $plainItem = new Item;
            $plainItem->addField(new Field(Field::CONTENT_TRANSFER_ENCODING, array('base64')));
            $plainItem->addField(new Field(Field::CONTENT_TYPE, array('text/plain', 'charset=UTF-8', 'format=flowed')));
            $plainItem->setValue(base64_encode($plain));

            $content->insertItem($plainItem);
        }

        if (self::isPresent($html)) {
            $content->insertBoundary($innerBoundary);

            $htmlItem = new Item;
            $htmlItem->addField(new Field(Field::CONTENT_TRANSFER_ENCODING, array('7bit')));
            $htmlItem->addField(new Field(Field::CONTENT_TYPE, array('text/html', 'charset=UTF-8')));
            $htmlItem->setValue($html);

            $content->insertItem($htmlItem);
        }

        $content->closeBoundary($innerBoundary);

        foreach ($attachments as $attachment) {
            $content->insertBoundary($outerBoundary);

            $item = new Item;
            $item->addField(new Field(
                    Field::CONTENT_DISPOSITION,
                    array('attachment', "filename=\"{$attachment->getName()}\""))
            );
            $item->addField(new Field(
                    Field::CONTENT_TYPE,
                    array($attachment->getContentType(), "name=\"{$attachment->getName()}\"")
            ));
            $item->addField(new Field(Field::CONTENT_TRANSFER_ENCODING, array('base64')));
            $item->setValue($attachment->getBody());

            $content->insertItem($item);
        }

        $content->closeBoundary($outerBoundary);
        return $content->getOutput();
    }

    /**
     * Evaluates presence of a value.
     * It adds additional checks for string or array
     *
     * @param $var
     * @return bool
     */
    private static function isPresent($var) {
        return (isset($var) && (
                (is_string($var) && trim($var) != '') ||
                (is_array(($var) && count($var) > 0)) ||
                (!is_array($var) && !is_string($var)))
        );
    }
}