<?php

/* composer autoloaders */
include '../vendor/autoload.php';

/* detect current language */
if (isset($_GET['locale'])) {
    $locale = $_GET['locale'];
} elseif (isset($argv[1])) {
    $locale = $argv[1];
} else {
    $locale = 'en_CA';
} //if

/* setup environment */
putenv("LANG=" . $locale);
putenv("LANGUAGE=" . $locale);
setlocale(LC_ALL, $locale);

/* setup extractor */
$extractor = new \Lexiconic\Extractor\GettextExtractor('simple', __DIR__ .'/locale/');

/* get term functions */
$_ = $extractor->getTermFunction();
$_n = $extractor->getPluralTermFunction();


/* some examples */

echo $_('Ok this is simple enough'), PHP_EOL;

for ($numberOfReasons = 1; $numberOfReasons < 4; $numberOfReasons++) {
    $translatedString = $_n('There this is %d good reason to use PHP', 'There are %d good reasons to use PHP', $numberOfReasons);
    echo sprintf($translatedString, $numberOfReasons), PHP_EOL;
} //for
