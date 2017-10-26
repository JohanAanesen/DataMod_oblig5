<?php

$doc = new DOMDocument();
$doc->load('SkierLogs.xml');
$doc->normalize();
$xpath = new DOMXPath($doc);


$query = "//Season[@fallYear='2016']//*[contains(Area,'Venabygd')]/../../@userName";

$entries = $xpath->query($query);

foreach( $entries as $entry ){
  echo "$entry->nodeValue <br>"; //<br> or \n samesame
}

?>
