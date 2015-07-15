<?php

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

            if ($value == 'on' || $value == 'true' || $value == 'yes') {
                $value = true;
            } else if ($value == 'off' || $value == 'false' || $value == 'no') {
                $value = false;
            }
            else if (preg_match('/^\d+$/', $value) == 1) {
                echo 'int';
                $value = intval($value);
            } else if (preg_match('/^[\d\.]+$/', $value)) {
                echo 'float';
                $value = floatval($value);
            }

            $this->configValues[trim($parts[0])] = $value;

        }

    }

}