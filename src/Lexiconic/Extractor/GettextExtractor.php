<?php
/**
 * Builds translation function to extract string using gettext functions
 *
 * @since  2014-04-13
 * @author Patrick Forget <patforg@geekpad.ca>
 */

namespace Lexiconic\Extractor;

/**
 * Builds translation function to extract string using gettext functions
 *
 * @since  2014-04-13
 * @author Patrick Forget <patforg@geekpad.ca>
 */
class GettextExtractor implements ExtractorInterface
{

    /**
     * @var string
     */
    private $domain = "";

    /**
     * @var string
     */
    private $path = "";

    /**
     * @var boolean
     */
    private $initialized = false;

    /**
     * @var Callable
     */
    private $extractorFunction = null;

    /**
     * @var Callable
     */
    private $pluralExtractorFunction = null;

    /**
     * @var string
     */
    private $encoding = 'UTF-8';

    /**
     * retrieve value for encoding
     *
     * @since  2014-04-13
     * @author Patrick Forget <patforg@geekpad.ca>
     *
     * @return string current value of encoding
     */
    public function getEncoding() {
        return $this->encoding;
    } // getEncoding()

    /**
     * assign value for encoding
     *
     * @since  2014-04-13
     * @author Patrick Forget <patforg@geekpad.ca>
     *
     * @param string value to assign to encoding
     */
    public function setEncoding($value) {
        $this->encoding = $value;
    } // setEncoding()

    /**
     * class constructor
     *
     * @since  2014-04-13
     * @author Patrick Forget <patforg@geekpad.ca>
     *
     * @param string $domain
     * @param string $path
     *
     * @throws \InvalidArgumentException will be thrown if domain or path are not strings or are empty stirngs
     */
    public function __construct($domain, $path) {

        if (!is_string($domain) || strlen($domain) === 0) {
            throw new \InvalidArgumentException('Expecting domain to be a non empty string');
        } //if


        if (!is_string($path) || strlen($path) === 0) {
            throw new \InvalidArgumentException('Expecting path to be a non empty string');
        } //if

        if (!file_exists($path)) {
            throw new \InvalidArgumentException("The specified path does not exists ({$path})");
        } //if

        $this->domain = $domain;
        $this->path = $path;
    } // __construct()

    /**
     * {@inheritdoc}
     */
    public function getExtractorFunction() {
        if (!$this->initialized) {
            $this->init();
        } //if

        return $this->extractorFunction;
    } // getExctractorFunction()

    /**
     * {@inheritdoc}
     */
    public function getPluralExtractorFunction() {
        
        if (!$this->initialized) {
            $this->init();
        } //if

        return $this->pluralExtractorFunction;

    } // getPluralExtractorFunction()

    /**
     * creates functions and binds path and encoding to domain
     *
     * @since  2014-04-13
     * @author Patrick Forget <patforg@geekpad.ca>
     */
    private function init() {
        if ($this->initialized) {
            return;
        } //if 

        $domain = $this->domain;
        bindtextdomain($domain, $this->path);
        bind_textdomain_codeset($domain, $this->getEncoding());

        /* anonymous function that retreives non varying strings (not plural) */
        $this->extractroFunction = function ($messageKey, $context = null) use ($domain) {

            if ($context === null) {
                return dgettext($domain, $messageKey);
            } else {
                $contextString = "{$context}\004{$messageKey}";
                $translation = dgettext($domain, $contextString);
                return ($translation === $contextString ? $messageKey : $translation);
            } //if
        };

        /* anonymous function that retreives the plural form  */
        $this->pluralExtractorFunction = function ($messageKey, $pluralKey, $number, $context = null) use ($domain) {

            if ($context === null) {
                return dngettext($domain, $messageKey, $pluralKey, $number);
            } else {
                $contextString = "{$context}\004{$messageKey}";
                $pluralContextString = "{$context}\004{$messageKey}";
                $translation = dngettext($domain, $contextString, $pluralContextString, $number);
                return ($translation === $contextString ? $messageKey : $translation);
            } //if
        };

    } // init()


} //  GettextExtractor class
