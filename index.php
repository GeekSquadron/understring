<?php

require_once 'understring.php';
//require_once 'underscore.php';

$string = " foobar";

echo '<pre>';

print_r(__::chain($string)->capitalize('haha')->levenshtein($string, 'haha', true)->value());

echo '</pre>';