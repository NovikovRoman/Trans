<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Trans\Trans;

class TransTest extends TestCase
{
    private $pathDictionary = '/dictionaries/';

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->pathDictionary = __DIR__ . $this->pathDictionary;
    }

    public function testLocaleRu()
    {
        $locale = 'ru';
        $strict = true;
        $trans = new Trans($this->pathDictionary, $locale, $strict);
        $this->assertEquals($trans->get('Hello, World!'), 'Привет, мир!');
    }

    public function testChangeLocale()
    {
        $locale = 'ru';
        $strict = true;
        $trans = new Trans($this->pathDictionary, $locale, $strict);
        $this->assertEquals($trans->get('Hello, World!'), 'Привет, мир!');
        $trans->setLocale('fr');
        $this->assertEquals($trans->get('Hello, World!'), 'Bonjour tout le monde!');
    }

    public function testNotStrictDefaultValue()
    {
        $locale = 'de';
        $trans = new Trans($this->pathDictionary, $locale);
        $text = 'Hello, World!';
        $this->assertEquals($trans->get($text), $text);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testStrictEmptyPathDictionaries()
    {
        $locale = 'en';
        $strict = true;
        new Trans('', $locale, $strict);
    }

    /**
     * @expectedException \Exception
     */
    public function testStrictPathDictionariesNotFound()
    {
        $locale = 'en';
        $strict = true;
        new Trans(__DIR__ . '/not-found', $locale, $strict);
    }

    /**
     * @expectedException \Exception
     */
    public function testStrictPathDictionariesNotDirectory()
    {
        $locale = 'en';
        $strict = true;
        new Trans(__FILE__, $locale, $strict);
    }

    /**
     * @expectedException \Exception
     */
    public function testStrictBugDictionary()
    {
        $locale = 'bug';
        $strict = true;
        new Trans($this->pathDictionary, $locale, $strict);
    }
}