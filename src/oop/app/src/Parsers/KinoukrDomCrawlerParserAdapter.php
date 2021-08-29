<?php

namespace src\oop\app\src\Parsers;

use Symfony\Component\DomCrawler\Crawler;

class KinoukrDomCrawlerParserAdapter implements ParserInterface
{
    private $domCrawler;

    public function __construct()
    {
        $this->domCrawler = new Crawler();
    }

    /**
     * @param string $siteContent
     * @return mixed
     */
    public function parseContent(string $siteContent)
    {
        $this->domCrawler->addHtmlContent($siteContent);

        $movieTitle = $this->domCrawler->filter('body main .ftitle > h1')->text();
        $moviePoster = $this->domCrawler->filter('body main .fposter > a')->first()->attr('href');
        $movieDescription = $this->domCrawler->filter('body main .fdesc')->text();

        return [
            'title'       => $movieTitle,
            'poster'      => $moviePoster,
            'description' => $movieDescription,
        ];
    }
}