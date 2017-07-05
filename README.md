Simple translations
===================

```
<?php
require_once __DIR__ . '/vendor/autoload.php'

$locale = 'ru';
// throw exceptions [optional] default: false
$strict = true;
$trans = new Trans([path-to-dir-dictionaries], $locale, $strict);

print_r($trans->get('Hello, World!'));

/**
 * Exception: not found dictionary
 * $trans->setLocale('de');
 * $trans->get('Hello, World!')
 */

// silent mode
$locale = 'de';
$trans = new Trans([path-to-dir-dictionaries], $locale);
// output: Hello, World!
print_r($trans->get('Hello, World!'));
```