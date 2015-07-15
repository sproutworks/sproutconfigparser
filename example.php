<?php

/**
 * This script is an example of the usage of SproutConfigParser
 */
require 'lib/SproutConfigParser.php';

$parser = new SproutConfigParser('example.conf');

$settingNames = array('server_id', 'server_load_alarm', 'verbose', 'log_file_path');

// dump values of some settings
foreach($settingNames as $name) {
    echo "$name:\n";
    var_dump($parser->getValue($name));
}

$parser->dumpValues();
