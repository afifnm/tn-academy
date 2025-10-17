<?php
$thirdPartyDir = dirname(__DIR__) . DIRECTORY_SEPARATOR;

$prefixes = [
    'PhpOffice\\PhpSpreadsheet\\' => $thirdPartyDir . 'PhpSpreadsheet' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'PhpSpreadsheet' . DIRECTORY_SEPARATOR,
    'Psr\\SimpleCache\\' => $thirdPartyDir . 'Psr' . DIRECTORY_SEPARATOR . 'SimpleCache' . DIRECTORY_SEPARATOR,
];

spl_autoload_register(function ($class) use ($prefixes) {
    foreach ($prefixes as $prefix => $base_dir) {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            continue;
        }

        $relative_class = substr($class, $len);
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});