Lexiconic
=========

Utility and classes to facilitate gettext style translations in PHP

Usage
-----

Example file simple.php:
```PHP
/* detect current language */
if (isset($_GET['locale'])) {
    $locale = $_GET['locale'];
} else {
    $locale = 'en_CA';
} //if

/* setup environment */
putenv("LANG=" . $locale);
putenv("LANGUAGE=" . $locale);
setlocale(LC_ALL, $locale);

/* setup extractor */
$extractor = new \Lexiconic\Extractor\GettextExtractor('application', __DIR__ .'/locale/');

/* get term functions */
$_ = $extractor->getTermFunction();

/* Use string extractor function */
echo $_('Ok this is simple enough'), PHP_EOL;

```

To scan files for terms you would run something like:
```bash
xgettext --language=PHP \\
  --keyword=_:1 --keyword=_:1,2c \\
  --keyword=_n:1,2 --keyword=_n:1,2,4c \\
  --output=./locale/simple.po  ./simple.php
```


Features
--------
* Supports context in strings
* Abstracts the gettex library to support other methods
* Does not invate global scope
 
To Do
-----
* scripts to extract strings
* scripts to generate mo
* classes to manipulate po files
* implement other extractors
* unit tests
* more examples
