<?php

$doc = new DOMDocument();
$doc->load('SkierLogs.xml');
$doc->normalize();
$xpath = new DOMXPath($doc);


$query = "//Season[@fallYear='2016']//Skier[@userName='idar_kals1']/*/*[Area='Lygna']/Date";

$entries = $xpath->evaluate($query);

foreach( $entries as $entry ){
  echo "$entry->nodeValue <br>"; //<br> or \n samesame
}

?>
