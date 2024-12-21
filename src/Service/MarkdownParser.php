<?php

namespace App\Service;

use League\CommonMark\CommonMarkConverter;

class MarkdownParser
{
    private CommonMarkConverter $converter;

    public function __construct()
    {
        $this->converter = new CommonMarkConverter([
            'html_input' => 'strip', // Optionnel : empêche les balises HTML dans le Markdown.
            'allow_unsafe_links' => false, // Désactive les liens non sécurisés.
        ]);
    }

    public function parse(string $markdown): string
    {
        return $this->converter->convertToHtml($markdown);
    }
}
