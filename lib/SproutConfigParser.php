<?php

/**
 * Class SproutConfigParser
 *
 * Parses a text file containing configuration settings
 */
class SproutConfigParser {

    private $configValues = [];

    function __construct($fileName) {
        $configFile = fopen($fileName, 'r');
        $curLine = 0;

        while(($line = fgets($configFile)) !== false) {
            $line = trim($line);
            ++$curLine;

            // ignore comments and empty lines
            if (substr($line, 0, 1) == '#' || strlen($line) == 0) {
                continue;
            }

            $parts = explode('=', $line);

            if (count($parts) != 2) {
                echo "ERROR: line $curLine is invalid: $line\n";
            }

            $value = trim($parts[1]);

            // convert to boolean if appropriate
            if ($value == 'on' || $value == 'true' || $value == 'yes') {
                $value = true;
            } else if ($value == 'off' || $value == 'false' || $value == 'no') {
                $value = false;
            }
            // convert to int or float
            else if (preg_match('/^\d+$/', $value) == 1) {
                $value = intval($value);
            } else if (preg_match('/^[\d\.]+$/', $value)) {
                $value = floatval($value);
            }

            $this->configValues[trim($parts[0])] = $value;
        }
    }

    /**
     * Get a config value
     * @param $name string Setting name
     * @return mixed
     */
    public function getValue($name) {
        if (isset($this->configValues[$name])) {
            return $this->configValues[$name];
        }
        return false;
    }

    /**
     * Dump all config values
     */
    public function dumpValues() {
        var_dump($this->configValues);
    }

}