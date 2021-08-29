<?php
/**
 * Create Class - Scrapper with method getMovie().
 * getMovie() - should return Movie Class object.
 *
 * Note: Use next namespace for Scrapper Class - "namespace src\oop\app\src;"
 * Note: Don't forget to create variables for TransportInterface and ParserInterface objects.
 * Note: Also you can add your methods if needed.
 */

namespace src\oop\app\src;

use src\oop\app\src\Models\Movie;
use src\oop\app\src\Parsers\ParserInterface;
use src\oop\app\src\Transporters\TransportInterface;

class Scrapper
{
    private $transporter;
    private $parser;
    private $movie;

    public function __construct(TransportInterface $transporter, ParserInterface $parser)
    {
        $this->transporter = $transporter;
        $this->parser = $parser;
        $this->movie = new Movie();
    }

    /**
     * @param string $url
     */
    public function getMovie(string $url)
    {
        $siteContent = $this->transporter->getContent($url);
        $parseData = $this->parser->parseContent($siteContent);

        $this->movie->setTitle($parseData['title']);
        $this->movie->setPoster($parseData['poster']);
        $this->movie->setDescription($parseData['description']);

        return $this->movie;
    }
}