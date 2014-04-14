<?php
/**
 * Static factory that builds extractors
 *
 * @since  2014-04-13
 * @author Patrick Forget <patforg@geekpad.ca>
 */

namespace Lexiconic;

/**
 * Static factory that builds extractors
 *
 * @since  2014-04-13
 * @author Patrick Forget <patforg@geekpad.ca>
 */
class Factory
{
    /**
     * Holds a reference to all extractors
     * 
     * @var array
     */
    private static $extractors = array();

    /**
     * Holds configuration to use for extractors
     *
     * @var array 
     */
    private static $config = array();

    /**
     * Retrieve singular term function for a given domain
     *
     * @since  2014-04-13
     * @author Patrick Forget <patforg@geekpad.ca>
     */
    public static function getTermFunction($domain) {
        if (!isset(self::$extractors[$domain])) {
            self::initDomain($domain);
        } //if

        $extractor = self::$extractors[$domain];

        return ($extractor instanceof Extractor\ExtractorInterface ? $extractor->getTermFunction() : null);
    } // getExtractorFunction()

    /**
     * Retrieve plural term function for a given domain
     *
     * @since  2014-04-13
     * @author Patrick Forget <patforg@geekpad.ca>
     */
    public static function getPluralTermFunction($domain) {
        if (!isset(self::$extractors[$domain])) {
            self::initDomain($domain);
        } //if

        $extractor = self::$extractors[$domain];

        return ($extractor instanceof Extractor\ExtractorInterface ? $extractor->getPluralTermFunction() : null);
    } // getPluralExtractorFunction()

    /**
     * Assigns config values
     *
     * @since  2014-04-13
     * @author Patrick Forget <patforg@geekpad.ca>
     */
    public static function setConfig($config) {
        self::$config = $config;
    } // setConfig()

    /**
     * Retrieve config values
     *
     * @since  2014-04-13
     * @author Patrick Forget <patforg@geekpad.ca>
     */
    public static function getConfig() {
        return self::$config;
    } // getConfig()

    /**
     * initialize a domain
     *
     * @since  2014-04-13
     * @author Patrick Forget <patforg@geekpad.ca>
     */
    private static function initDomain($domain) {
        if (isset(self::$extractors[$domain])) {
            return;
        } //if

        $path = isset(self::$config['path']) ? self::$config['path'] : '';

        $extractor = new Extractor\GettextExtractor($domain, $path);

        if (isset(self::$config['encoding'])) {
            $extractor->setEncoding(self::$config['encoding']);
        } //if

        self::$extractors[$domain] = $extractor;

    } // initDomain()

} //  Factory class
