<?php

$doc = new DOMDocument();
$doc->load('SkierLogs.xml');
$doc->normalize();
$xpath = new DOMXPath($doc);


$query = "//SkierLogs/Skiers/Skier[@userName=../../Season[@fallYear='2015']/Skiers/Skier/*/Entry[Area='Nordseter']/../../@userName and not(@userName=../../Season[@fallYear='2016']/Skiers/Skier/*/Entry[Area='Nordseter']/../../@userName)]";

$entries = $xpath->evaluate($query);

foreach( $entries as $entry ){
  echo "$entry->nodeValue <br>"; //<br> or \n samesame
}

?>
