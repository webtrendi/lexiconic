<?php
/**
 * Define common methods to term extractors
 *
 * @since  2014-04-13
 * @author Patrick Forget <patforg@geekpad.ca>
 */

namespace Lexiconic\Extractor;

/**
 * Define common methods to term extractors
 *
 * @since  2014-04-13
 * @author Patrick Forget <patforg@geekpad.ca>
 */
interface ExtractorInterface
{

    /**
     * Retrieve function for singular term lookup
     *
     * @since  2014-04-13
     * @author Patrick Forget <patforg@geekpad.ca>
     *
     * @returns Callable anonymous function taking 2 parameters 
     *     first param takes the string in its original language
     *     second param is optional and takes the context of the string
     */
    public function getExtractorFunction();


    /**
     * Retrieve function for plural term lookup
     *
     * @since  2014-04-13
     * @author Patrick Forget <patforg@geekpad.ca>
     *
     * @returns Callable anonymous function taking 4 parameters 
     *     first param takes the singular string its original language
     *     second  param takes the plural string in its original language
     *     third param takes the the number of items related to the string
     *     fourth param is optional and takes the context of the string
     */
    public function getPluralExtractorFunction();

} // ExtractorInterface interface
