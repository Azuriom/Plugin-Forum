<?php

namespace Azuriom\Plugin\Forum\Support;

use Azuriom\Plugin\Forum\CommonMark\ExternalImage\ExternalImageExtension;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;

class Markdown
{
    public static function parse(string $text)
    {
        $environment = Environment::createCommonMarkEnvironment();
        $environment->addExtension(new GithubFlavoredMarkdownExtension());
        $environment->addExtension(new ExternalLinkExtension());
        $environment->addExtension(new ExternalImageExtension());

        $internalHosts = [preg_replace('(^https?://)', '', config('app.url'))];

        $converter = new CommonMarkConverter([
            'html_input' => 'escape',
            'allow_unsafe_links' => false,
            'max_nesting_level' => 10,
            'external_link' => [
                'internal_hosts' => $internalHosts,
                'open_in_new_window' => true,
            ],
            'external_image' => [
                'internal_hosts' => $internalHosts,
                'image_proxy' => 'https://images.weserv.nl/?url=%s',
            ],
        ], $environment);

        return $converter->convertToHtml($text);
    }

    public static function parseRaw(string $text)
    {
        $environment = Environment::createCommonMarkEnvironment();
        $environment->addExtension(new GithubFlavoredMarkdownExtension());

        $converter = new CommonMarkConverter([], $environment);

        return $converter->convertToHtml($text);
    }
}
