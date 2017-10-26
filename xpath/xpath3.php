<?php

$doc = new DOMDocument();
$doc->load('SkierLogs.xml');
$doc->normalize();
$xpath = new DOMXPath($doc);


$query = "//Season[@fallYear='2015']/Skiers[@clubId='vindil']/*/Log[sum(./*/Distance)>10]";

$entries = $xpath->query($query);

foreach( $entries as $entry ){
  echo "$entry->nodeValue <br>\n"; //<br> or \n samesame
}

 ?>
