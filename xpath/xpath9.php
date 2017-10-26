<?php

$doc = new DOMDocument();
$doc->load('SkierLogs.xml');
$doc->normalize();
$xpath = new DOMXPath($doc);


$query = "//SkierLogs/Skiers/Skier[@userName=../../Season[@fallYear='2015']/Skiers[@clubId=../../Clubs/Club[County='Oppland']/@id]/Skier/@userName]";

$entries = $xpath->evaluate($query);

foreach( $entries as $entry ){
  echo "$entry->nodeValue <br>"; //<br> or \n samesame
}

?>
