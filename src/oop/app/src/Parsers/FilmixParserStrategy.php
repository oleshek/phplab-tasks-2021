<?php

namespace src\oop\app\src\Parsers;

class FilmixParserStrategy implements ParserInterface
{
    /**
     * @param string $siteContent
     * @return mixed
     */
    public function parseContent(string $siteContent)
    {
        preg_match('/title-one-line[\s\S]*<h1.*?>(.*)<\/h1>/', $siteContent, $movieTitle);
        preg_match('/<img src="(.*?)".*?class="poster poster-tooltip"/', $siteContent, $moviePoster);
        preg_match('/<div class="full-story">[\s\S]*?(.*?)<\/div>/', $siteContent, $movieDescription);

        return [
            'title'       => $movieTitle[1],
            'poster'      => $moviePoster[1],
            'description' => $movieDescription[1],
        ];
    }
}