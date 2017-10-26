<?php

$doc = new DOMDocument();
$doc->load('SkierLogs.xml');
$doc->normalize();
$xpath = new DOMXPath($doc);


$query = "sum(//Season[@fallYear='2015']/Skiers[not(@clubId)]//Distance)";

$entries = $xpath->evaluate($query);

echo "$entries"

?>
