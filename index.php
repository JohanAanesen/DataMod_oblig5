<?php
/**
 * Created by IntelliJ IDEA.
 * User: Johan Aanesen
 * Date: 11/2/2017
 * Time: 18:15
 */

$doc = new DOMDocument();
$doc->load('SkierLogs.xml');
$doc->normalize();
$xpath = new DOMXPath($doc);

$db = pdoCon();
/*
---Clubs
---Skiers
---@seasons
---season/@What club ^
---season/club/skier/sum(distance)
*/

$seasons = getSeasons($xpath);
foreach ($seasons as $season) {
    injectSeason($db, $season);
}
injectNone($db);

$clubids2 = getClubID2($xpath);
$clubnames = getClubNames($xpath);
$clubcity = getClubCity($xpath);
$clubcounty = getClubCounty($xpath);

for($x = 0; $x < sizeof($clubnames); $x++) {
    injectClubs($db, $clubids2[$x], $clubnames[$x], $clubcity[$x], $clubcounty[$x]);
}

$usernames2 = getUsername2($xpath);
$firstnames = getfirstName($xpath);
$lastnames = getlastName($xpath);
$dob = getDOB($xpath);

for($x = 0; $x < sizeof($usernames2); $x++) {
    injectSkier($db, $usernames2[$x], $firstnames[$x], $lastnames[$x], $dob[$x]);
}


foreach ($seasons as $season){

    $clubids = getClubID($xpath, $season);

    foreach ($clubids as $clubID){

        $usernames = getUsernames($xpath, $season, $clubID);

        foreach ($usernames as $username){
           // echo "$season $clubID $username: ".getTotalDist($xpath, $season, $username, $clubID)."<br>";
            $totalDist = getTotalDist($xpath, $season, $username, $clubID);

            //injects into sql
            injectOverview($db, $season, $clubID, $username, $totalDist);

        }
    }
}

function getSeasons(DOMXPath $xpath){
    $seasons = array();
    $query = "//@fallYear";
    $entries = $xpath->evaluate($query);

    foreach( $entries as $entry ){
        $seasons[] = $entry->nodeValue;
    }
    return $seasons;

}

function getClubID(DOMXPath $xpath, $season){
    $clubids = array();
    $query = "//Season[@fallYear='".$season."']/Skiers/@clubId";
    $entries = $xpath->evaluate($query);

    foreach( $entries as $entry ){
        $clubids[] = $entry->nodeValue;
    }
    return $clubids;
}

function getClubID2(DOMXPath $xpath){
    $clubids = array();
    $query = "//SkierLogs/Clubs/Club/@id";
    $entries = $xpath->evaluate($query);

    foreach( $entries as $entry ){
        $clubids[] = $entry->nodeValue;
    }
    return $clubids;
}

function getClubNames(DOMXPath $xpath){
    $clubnames = array();
    $query = "//Clubs/Club/Name";
    $entries = $xpath->evaluate($query);

    foreach( $entries as $entry ){
        $clubnames[] = $entry->nodeValue;
    }
    return $clubnames;
}
function getClubCity(DOMXPath $xpath){
    $clubcity = array();
    $query = "//Clubs/Club/City";
    $entries = $xpath->evaluate($query);

    foreach( $entries as $entry ){
        $clubcity[] = $entry->nodeValue;
    }
    return $clubcity;
}
function getClubCounty(DOMXPath $xpath){
    $clubcounty = array();
    $query = "//Clubs/Club/County";
    $entries = $xpath->evaluate($query);

    foreach( $entries as $entry ){
        $clubcounty[] = $entry->nodeValue;
    }
    return $clubcounty;
}

function getUsernames(DOMXPath $xpath, $season, $clubID){
    $usernames = array();

    $query = "//Season[@fallYear='".$season."']/Skiers[@clubId='".$clubID."']/Skier/@userName";
    $entries = $xpath->evaluate($query);

    foreach( $entries as $entry ){
        $usernames[] = $entry->nodeValue;
 //       echo "$entry->nodeValue <br>"; //<br> or \n samesame
    }
    return $usernames;
}

function getUsername2(DOMXPath $xpath){
    $usernames = array();
    $query = "//SkierLogs/Skiers/Skier/@userName";
    $entries = $xpath->evaluate($query);

    foreach( $entries as $entry ){
        $usernames[] = $entry->nodeValue;
    }
    return $usernames;
}

function getfirstName(DOMXPath $xpath){
    $firstnames = array();
    $query = "//SkierLogs/Skiers/Skier/FirstName";
    $entries = $xpath->evaluate($query);

    foreach( $entries as $entry ){
        $firstnames[] = $entry->nodeValue;
    }
    return $firstnames;
}

function getlastName(DOMXPath $xpath){
    $lastnames = array();
    $query = "//SkierLogs/Skiers/Skier/LastName";
    $entries = $xpath->evaluate($query);

    foreach( $entries as $entry ){
        $lastnames[] = $entry->nodeValue;
    }
    return $lastnames;
}

function getDOB(DOMXPath $xpath){
    $dob = array();
    $query = "//SkierLogs/Skiers/Skier/YearOfBirth";
    $entries = $xpath->evaluate($query);

    foreach( $entries as $entry ){
        $dob[] = $entry->nodeValue;
    }
    return $dob;
}

function getTotalDist(DOMXPath $xpath, $season, $username, $clubID){
    $query = "sum(//Season[@fallYear='".$season."']/Skiers[@clubId='".$clubID."']/Skier[@userName='".$username."']//Distance)";

    $distanse = $xpath->evaluate($query);

    return $distanse;

}


function pdoCon()
{
    try {
        // Create PDO connection
        $db = new PDO('mysql:host=localhost;dbname=oblig5;charset=utf8mb4', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //Sets the $db to the PDO $db :)

    } catch (PDOException $ex) {
        echo "Could not connect to database"; //Error message
    }

    return $db;
}

function injectSeason($db, $season){
    try{
        //SQL Injection SAFE query method:
        $query = "INSERT INTO season (fallYear)  VALUES (?)";
        $param = array($season);
        $stmt = $db->prepare($query);
        $stmt->execute($param);

    } catch(PDOException $ex){
        echo "Fuck".$ex; //Error message
    }
}

function injectClubs($db, $clubID, $clubname, $clubcity, $clubcounty){
    try{
        //SQL Injection SAFE query method:
        $query = "INSERT INTO skierclub (id, Name, City, County)  VALUES (?, ?, ?, ?)";
        $param = array($clubID, $clubname, $clubcity, $clubcounty);
        $stmt = $db->prepare($query);
        $stmt->execute($param);

    } catch(PDOException $ex){
        echo "Fuck".$ex; //Error message
    }
}

function injectSkier($db, $username, $firstname, $lastname, $dob){
    try{
        //SQL Injection SAFE query method:
        $query = "INSERT INTO skier (userName, firstName, lastName, yearOfBirth)  VALUES (?, ?, ?, ?)";
        $param = array($username, $firstname, $lastname, $dob);
        $stmt = $db->prepare($query);
        $stmt->execute($param);

    } catch(PDOException $ex){
        echo "Fuck".$ex; //Error message
    }
}

function injectNone($db){
    try{
        //SQL Injection SAFE query method:
        $query = "INSERT INTO skierclub (id)  VALUES (?)";
        $param = array("none");
        $stmt = $db->prepare($query);
        $stmt->execute($param);

    } catch(PDOException $ex){
        echo "Fuck".$ex; //Error message
    }
}

function injectOverview($db, $season, $clubID, $username, $totalDist){
    try{
        if ($clubID == ""){
            $clubID = "none";
        }
        //SQL Injection SAFE query method:
        $query = "INSERT INTO overview (userName, fallYear, id, Total)  VALUES (?, ?, ?, ?)";
        $param = array($username, $season, $clubID, $totalDist);
        $stmt = $db->prepare($query);
        $stmt->execute($param);

    } catch(PDOException $ex){
        echo "Fuck".$ex; //Error message
    }
}


?>

