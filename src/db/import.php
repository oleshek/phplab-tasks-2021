<?php
/**
 *  Open web/airports.php file
 *  Go through all airports in a loop and INSERT airports/cities/states to equivalent DB tables
 *  (make sure, that you do not INSERT the same values to the cities and states i.e. name should be unique i.e. before INSERTing check if record exists)
 */

/** @var \PDO $pdo */
require_once './pdo_ini.php';
require_once './functions.php';

foreach (require_once('../web/airports.php') as $item) {
    // Cities
    $cityId = insertCity($pdo, $item['city']);

    // States
    $stateId = insertState($pdo, $item['state']);

    // Airports
    insertAirports($pdo, $item, $cityId, $stateId);
}