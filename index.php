<?php

require_once 'understring.php';
//require_once 'underscore.php';

$string = " foobar";

echo '<pre>';

print_r(__::chain($string)->capitalize('haha')->levenshtein($string, 'haha', true)->value());

echo '<br>';

$test = 'Hello ';
$test2 = 'image.gif';
print_r(__::startsWith($test2, 'imag'));


echo '</pre>';