<?php

/**
 * @param \PDO $pdo
 * @param string $cityName
 * @return int
 */
function insertCity(\PDO $pdo, string $cityName): int
{
    // To check if city with this name exists in the DB we need to SELECT it first
    $sth = $pdo->prepare('SELECT id FROM cities WHERE name = :name');
    $sth->setFetchMode(\PDO::FETCH_ASSOC);
    $sth->execute(['name' => $cityName]);
    $city = $sth->fetch();

    // If result is empty - we need to INSERT city
    if (!$city) {
        $sth = $pdo->prepare('INSERT INTO cities (name) VALUES (:name)');
        $sth->execute(['name' => $cityName]);

        // We will use this variable to INSERT airport
        $cityId = $pdo->lastInsertId();
    } else {
        // We will use this variable to INSERT airport
        $cityId = $city['id'];
    }

    return $cityId;
}

/**
 * @param \PDO $pdo
 * @param string $stateName
 * @return int
 */
function insertState(\PDO $pdo, string $stateName): int
{
    // To check if state with this name exists in the DB we need to SELECT it first
    $sth = $pdo->prepare('SELECT id FROM states WHERE name = :name');
    $sth->setFetchMode(\PDO::FETCH_ASSOC);
    $sth->execute(['name' => $stateName]);
    $state = $sth->fetch();

    // If result is empty - we need to INSERT state
    if (!$state) {
        $sth = $pdo->prepare('INSERT INTO states (name) VALUES (:name)');
        $sth->execute(['name' => $stateName]);

        // We will use this variable to INSERT airport
        $stateId = $pdo->lastInsertId();
    } else {
        // We will use this variable to INSERT airport
        $stateId = $state['id'];
    }

    return $stateId;
}

/**
 * @param $pdo
 * @param array $data
 * @param int $cityId
 * @param int $stateId
 * @return int
 */
function insertAirports(\PDO $pdo, array $data, int $cityId, int $stateId): int
{
    $sth = $pdo->prepare('INSERT INTO airports (name, code, city_id, state_id, address, timezone) VALUES (:name, :code, :cityId, :stateId, :address, :timezone)');
    $sth->execute([
        'name'     => $data['name'],
        'code'     => $data['code'],
        'cityId'   => $cityId,
        'stateId'  => $stateId,
        'address'  => $data['address'],
        'timezone' => $data['timezone'],
    ]);

    return $pdo->lastInsertId();
}

/**
 * @param \PDO $pdo
 * @return array|false
 */
function getUniqueFirstLetters(\PDO $pdo)
{
    $sth = $pdo->query('SELECT DISTINCT LEFT(name, 1) FROM cities ORDER BY name');

    return $sth->fetchAll(\PDO::FETCH_COLUMN, 0);
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
 * @param PDO $pdo
 * @return array
 */
function getAriportsForPageAndCountTotal(\PDO $pdo)
{
    $sql = '
        FROM
            airports a
        JOIN
            states s ON s.id = a.state_id
        JOIN
            cities c ON c.id = a.city_id
        WHERE
            1';

    if (!empty($_GET['filter_by_first_letter'])) {
        $sql .= " AND c.name LIKE '$_GET[filter_by_first_letter]%'";
    }
    if (!empty($_GET['filter_by_state'])) {
        $sql .= " AND s.name = '$_GET[filter_by_state]'";
    }

    $queryForData = 'SELECT a.id, a.name as airport_name, a.code, a.address, a.timezone, s.name as state_name, c.name as city_name'.$sql;
    $queryForCountTotal = 'SELECT COUNT(a.id)'.$sql;

    if (!empty($_GET['sort'])) {
        switch ($_GET['sort']) {
            case 'name':
            case '-name':
                $queryForData .= ' ORDER BY a.name';
                break;
            case 'code':
            case '-code':
                $queryForData .= ' ORDER BY a.code';
                break;
            case 'state':
            case '-state':
                $queryForData .= ' ORDER BY s.name';
                break;
            case 'city':
            case '-city':
                $queryForData .= ' ORDER BY c.name';
                break;
        }

        if (mb_substr($_GET['sort'], 0, 1) === '-') {
            $queryForData .= ' DESC';
        }
    }

    $queryForData .= ' LIMIT '.ITEMLS_ON_PAGE.' OFFSET '.(CURRENT_PAGE - 1) * ITEMLS_ON_PAGE;
    $dataResult = $pdo->query($queryForData);
    $countTotalResult = $pdo->query($queryForCountTotal);

    return [$dataResult->fetchAll(\PDO::FETCH_ASSOC), $countTotalResult->fetchColumn()];
}


/**
 * @param int $itemsTotal
 * @return array
 */
function getPaginationLinks(int $itemsTotal): array
{
    $numberOfPages = ceil(($itemsTotal / ITEMLS_ON_PAGE));
    $paginationLinks = [];
    while ($numberOfPages > 0) {
        $_GET['page'] = $numberOfPages;
        $paginationLinks[$numberOfPages--] = '?'.http_build_query($_GET);
    }
    natsort($paginationLinks);

    return $paginationLinks;
}