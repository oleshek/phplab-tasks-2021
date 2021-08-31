<?php
/**
 * The $airports variable contains array of arrays of airports (see airports.php)
 * What can be put instead of placeholder so that function returns the unique first letter of each airport name
 * in alphabetical order
 *
 * Create a PhpUnit test (GetUniqueFirstLettersTest) which will check this behavior
 *
 * @param  array  $airports
 * @return string[]
 */
function getUniqueFirstLetters(array $airports)
{
    $uniqueLetters = [];
    foreach ($airports as $airport) {
        $firstLetter = mb_substr($airport['name'], 0, 1);
        $uniqueLetters[$firstLetter] = $firstLetter;
    }
    sort($uniqueLetters);

    return $uniqueLetters;
}

/**
 * @param string $letter
 * @return string
 */
function getQueryStringForFirstLetterFilter(string $letter): string
{
    $queryString = "?page=1&filter_by_first_letter=$letter";
    if (!empty($_GET['filter_by_state'])) {
        $queryString .= "&filter_by_state=$_GET[filter_by_state]";
    }

    return $queryString;
}

/**
 * @param string $state
 * @return string
 */
function getQueryStringForStateFilter(string $state): string
{
    $queryString = '?page=1';
    if (!empty($_GET['filter_by_first_letter'])) {
        $queryString .= "&filter_by_first_letter=$_GET[filter_by_first_letter]";
    }
    $queryString .= "&filter_by_state=$state";

    return $queryString;
}


/**
 * @param string $sortField
 * @return string
 */
function getQueryStringForSort(string $sortField): string
{
    if (empty($_SERVER['QUERY_STRING'])) {
        return "?sort=$sortField";
    } elseif (empty($_GET['sort'])) {
        return "?$_SERVER[QUERY_STRING]&sort=$sortField";
    } else {
        $queryParams = $_GET;
        $queryParams['sort'] = ($queryParams['sort'] === $sortField) ? "-$sortField" : $sortField;

        return '?'.http_build_query($queryParams);
    }
}

/**
 * @param array $airports
 * @param string $selectedLetter
 * @return array
 */
function filterByFirstLetter(array $airports, string $selectedLetter): array
{
    $filteredArray = [];
    foreach ($airports as $airport) {
        if (mb_substr($airport['name'], 0, 1) === $selectedLetter) {
            $filteredArray[] = $airport;
        }
    }

    return $filteredArray;
}

/**
 * @param array $airports
 * @param string $selectedState
 * @return array
 */
function filterByState(array $airports, string $selectedState): array
{
    $filteredArray = [];
    foreach ($airports as $airport) {
        if ($airport['state'] === $selectedState) {
            $filteredArray[] = $airport;
        }
    }

    return $filteredArray;
}

/**
 * @param array $airports
 * @param string $selectedState
 * @return array
 */
function sortAirports(array $airports, string $sortField): array
{
    $sortDesc = false;
    if (mb_substr($sortField, 0, 1) === '-') {
        $sortField = mb_substr($sortField, 1);
        $sortDesc = true;
    }

    usort($airports, function($a, $b) use ($sortField, $sortDesc) {
        if ($sortDesc) {
            return $b[$sortField] <=> $a[$sortField];
        }

        return $a[$sortField] <=> $b[$sortField];
    });

    return $airports;
}

/**
 * @param array $airports
 * @return array
 */
function getPaginationLinks(array $airports): array
{
    $numberOfPages = ceil((count($airports) / ITEMLS_ON_PAGE));
    $paginationLinks = [];
    while ($numberOfPages > 0) {
        $_GET['page'] = $numberOfPages;
        $paginationLinks[$numberOfPages--] = '?'.http_build_query($_GET);
    }
    natsort($paginationLinks);

    return $paginationLinks;
}

/**
 * @param array $airports
 * @return array
 */
function getAirportsForPage(array $airports): array
{
    return array_slice($airports, (CURRENT_PAGE -1)*ITEMLS_ON_PAGE, ITEMLS_ON_PAGE);
}