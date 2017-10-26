<?php

$doc = new DOMDocument();
$doc->load('SkierLogs.xml');
$doc->normalize();
$xpath = new DOMXPath($doc);


$query = "//Skier[@userName='mari_dahl']/Log/Entry";

$entries = $xpath->query($query);

foreach( $entries as $entry ){
  echo "$entry->nodeValue <br>"; //<br> or \n samesame
}

 ?>
