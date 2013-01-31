<?php

// \OpenHack\Application takes care of all the loading, so this file is mainly a short chainloader to that.

// The only thing we'll do right off is check if we have PHP5.4 or above. If not, the visitor will get a bunch of nasty,
// unhelpful parser errors as soon as we load Application.php from the [] array notation/namespace/etc.
list($php_version_major, $php_version_minor, $php_version_release) = explode('.', PHP_VERSION);
if ($php_version_major < 5 || $php_version_minor < 4) {
    echo '<!DOCTYPE html><html><head><title>Dependency Error</title></head><body>PHP &ge; 5.4 required.</body></html>';
    exit;
}

// Chainload!
require_once(implode(DIRECTORY_SEPARATOR, array(dirname(__FILE__), 'Includes', 'OpenHack', 'Application.php')));
