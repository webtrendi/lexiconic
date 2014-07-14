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
    public static function getTermFunction($domain, $options = array()) {

        $extractor = self::getExtractor($domain, $options);

        return ($extractor instanceof Extractor\ExtractorInterface ? $extractor->getTermFunction() : null);
    } // getExtractorFunction()

    /**
     * Retrieve plural term function for a given domain
     *
     * @since  2014-04-13
     * @author Patrick Forget <patforg@geekpad.ca>
     */
    public static function getPluralTermFunction($domain, $options = array()) {
        
        $extractor = self::getExtractor($domain, $options);

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
    private static function getExtractor($domain, $options = array()) {

        static $extractors = array();

        $scope = isset($options['scope']) ? $options['scope'] : 'app';

        $key = "{$domain}-{$scope}";

        if (!isset($extractors[$key])) {

            $path = isset(self::$config['scopes'][$scope]['path']) ? self::$config['scopes'][$scope]['path'] : '';

            $extractor = new Extractor\GettextExtractor($domain, $path);

            if (isset(self::$config['scopes'][$scope]['encoding'])) {
                $extractor->setEncoding(self::$config['scopes'][$scope]['encoding']);
            } //if

            $extractors[$key] = $extractor;
        } //if

        return $extractors[$key];

    } // initDomain()

} //  Factory class
