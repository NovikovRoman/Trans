<?php

namespace Trans;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class Trans
{
    const EXT = '.yml';
    private $strict;
    private $locale;
    private $dictionary;
    private $pathDictionaries;
    private $pathDictionary;

    public function __construct($pathDictionaries, $locale, $strict = false)
    {
        $this->locale = $locale;
        $this->strict = $strict;
        if (empty($pathDictionaries)) {
            throw new \InvalidArgumentException('Empty path to dictionaries.');
        }
        if (mb_substr($pathDictionaries, -1) != DIRECTORY_SEPARATOR) {
            $pathDictionaries .= DIRECTORY_SEPARATOR;
        }
        $this->pathDictionaries = $pathDictionaries;
        $this->getDictionary();
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
        $this->getDictionary();
    }

    public function get($text)
    {
        if (empty($this->dictionary) || !isset($this->dictionary[$text])) {
            return $text;
        }
        return $this->dictionary[$text];
    }

    private function getDictionary()
    {
        if (!$this->existsPath() || !$this->existsFile()) {
            return;
        }
        try {
            $this->dictionary = Yaml::parse(file_get_contents($this->pathDictionary));
        } catch (ParseException $e) {
            if ($this->strict) {
                throw new \Exception('Unable to parse the YAML string: ' . $e->getMessage());
            }
        }
    }

    private function existsFile()
    {
        $this->pathDictionary = $this->pathDictionaries . $this->locale . self::EXT;
        $isExists = file_exists($this->pathDictionary) && is_file($this->pathDictionary);
        if (!$isExists) {
            $this->pathDictionary = '';
            if ($this->strict) {
                throw new \Exception('Dictionary not found or it is not file.');
            }
        }
        return $isExists;
    }

    private function existsPath()
    {
        $isExists = file_exists($this->pathDictionaries) && is_dir($this->pathDictionaries);
        if ($this->strict && !$isExists) {
            throw new \Exception('Path to dictionaries not found or it is not directory.');
        }
        return $isExists;
    }
}