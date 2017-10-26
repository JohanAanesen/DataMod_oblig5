<?php

$doc = new DOMDocument();
$doc->load('SkierLogs.xml');
$doc->normalize();
$xpath = new DOMXPath($doc);


$query = "count(//Skier[YearOfBirth>='2002' and YearOfBirth<='2004'])";

$entries = $xpath->evaluate($query);

echo "$entries"

?>
