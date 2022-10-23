<?php

namespace Azuriom\Plugin\Forum\Support;

use Illuminate\Support\Str;
use League\CommonMark\Util\RegexHelper;

/**
 * Based on https://github.com/genert/bbcode, under the MIT license.
 * Modified to add more tags, produce safe HTML and fix issues with newlines.
 */
class BBCodeParser
{
    public array $parsers = [
        'h1' => [
            'pattern' => '/\[h1\](.*?)\[\/h1\]\n?/s',
            'replace' => '<h1>$1</h1>',
            'content' => '$1',
        ],

        'h2' => [
            'pattern' => '/\[h2\](.*?)\[\/h2\]\n?/s',
            'replace' => '<h2>$1</h2>',
            'content' => '$1',
        ],

        'h3' => [
            'pattern' => '/\[h3\](.*?)\[\/h3\]\n?/s',
            'replace' => '<h3>$1</h3>',
            'content' => '$1',
        ],

        'h4' => [
            'pattern' => '/\[h4\](.*?)\[\/h4\]\n?/s',
            'replace' => '<h4>$1</h4>',
            'content' => '$1',
        ],

        'h5' => [
            'pattern' => '/\[h5\](.*?)\[\/h5\]\n?/s',
            'replace' => '<h5>$1</h5>',
            'content' => '$1',
        ],

        'h6' => [
            'pattern' => '/\[h6\](.*?)\[\/h6\]\n?/s',
            'replace' => '<h6>$1</h6>',
            'content' => '$1',
        ],

        'bold' => [
            'pattern' => '/\[b\](.*?)\[\/b\]/s',
            'replace' => '<strong>$1</strong>',
            'content' => '$1',
        ],

        'italic' => [
            'pattern' => '/\[i\](.*?)\[\/i\]/s',
            'replace' => '<em>$1</em>',
            'content' => '$1',
        ],

        'underline' => [
            'pattern' => '/\[u\](.*?)\[\/u\]/s',
            'replace' => '<u>$1</u>',
            'content' => '$1',
            'recursive' => true,
        ],

        'linethrough' => [
            'pattern' => '/\[s\](.*?)\[\/s\]/s',
            'replace' => '<span style="text-decoration: line-through">$1</span>',
            'content' => '$1',
        ],

        'color' => [
            'pattern' => '/\[color\=(#\w{6}|#\w{3})\](.*?)\[\/color\]/s',
            'replace' => '<span style="color: $1">$2</span>',
            'content' => '$2',
            'recursive' => true,
        ],

        'center' => [
            'pattern' => '/\[center\](.*?)\[\/center\]\n?/s',
            'replace' => '<p style="text-align: center;">$1</p>',
            'content' => '$1',
        ],

        'left' => [
            'pattern' => '/\[left\](.*?)\[\/left\]\n?/s',
            'replace' => '<p style="text-align: left;">$1</p>',
            'content' => '$1',
        ],

        'right' => [
            'pattern' => '/\[right\](.*?)\[\/right\]\n?/s',
            'replace' => '<p style="text-align: right;">$1</p>',
            'content' => '$1',
        ],

        'quote' => [
            'pattern' => '/\n?\[quote\]\n?(.*?)\[\/quote\]\n?/s',
            'replace' => '<blockquote>$1</blockquote>',
            'content' => '$1',
        ],

        'code' => [
            'pattern' => '/\n?\[code=?\]\n?(.*?)\[\/code\]\n?/s',
            'replace' => '<pre><code>$1</code></pre>',
            'content' => '$1',
        ],

        'named_code' => [
            'pattern' => '/\n?\[code\=(\w*?)\]\n?(.*?)\[\/code\]\n?/s',
            'replace' => '<pre class="language-$1"><code>$2</code></pre>',
            'content' => '$2',
        ],

        'link' => [
            'pattern' => '/\[url\](.*?)\[\/url\]/s',
            'replace' => '<a href="$1">$1</a>',
            'content' => '$1',
        ],

        'named_link' => [
            'pattern' => '/\[url\=(.*?)\](.*?)\[\/url\]/s',
            'replace' => '<a href="$1">$2</a>',
            'content' => '$2',
        ],

        'image' => [
            'pattern' => '/\[img\](.*?)\[\/img\]/s',
            'replace' => '<img src="$1">',
            'content' => '$1',
        ],

        'named_image' => [
            'pattern' => '/\[img\=(.*?)\](.*?)\[\/img\]/s',
            'replace' => '<img src="$2" alt="$1">',
            'content' => '$2',
        ],

        'ordered_list' => [
            'pattern' => '/\n?\[olist\]\n?(.*?)\[\/olist\]\n?/s',
            'replace' => '<ol>$1</ol>',
            'content' => '$1',
        ],

        'unordered_list' => [
            'pattern' => '/\n?\[list\]\n?(.*?)\[\/list\]\n?/s',
            'replace' => '<ul>$1</ul>',
            'content' => '$1',
        ],

        'list_item' => [
            'pattern' => '/\n?\[\*\]\n?(.*?)\[\/\*\]\n?/s',
            'replace' => '<li>$1</li>',
            'content' => '$1',
        ],

        'single_list_item' => [
            'pattern' => '/\[\*\](.*)\n?/',
            'replace' => '<li>$1</li>',
            'content' => '$1',
        ],

        'youtube' => [
            'pattern' => '/\n?\[youtube\](?:https?:\/\/www\.youtube\.com\/watch\?v\=|https:\/\/youtu\.be\/)?(\w*?)\[\/youtube\]/s',
            'replace' => '<iframe width="560" height="315" src="//www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
            'content' => '$1',
        ],

        'linebreak' => [
            'pattern' => '/\n/',
            'replace' => '<br>',
            'content' => '',
        ],
    ];

    protected ?string $imageProxy;
    protected array $internalHosts;

    public function __construct(string $imageProxy = null, array $internalHosts = [])
    {
        $this->imageProxy = $imageProxy;
        $this->internalHosts = $internalHosts;

        $this->parsers['link']['callback'] = function ($matches) {
            return $this->handleLink($matches[1], $matches[1]);
        };
        $this->parsers['named_link']['callback'] = function ($matches) {
            return $this->handleLink($matches[1], $matches[2]);
        };

        if ($this->imageProxy !== null) {
            $this->parsers['image']['callback'] = function ($matches) {
                return $this->handleImage($matches[1], '');
            };
            $this->parsers['named_image']['callback'] = function ($matches) {
                return $this->handleImage($matches[2], $matches[1]);
            };
        }
    }

    /**
     * Parses the BBCode string.
     *
     * @param      $source
     * @param  bool  $caseInsensitive
     * @return string
     */
    public function parse($source, bool $caseInsensitive = false)
    {
        $source = e(str_replace("\r\n", "\n", $source));

        foreach ($this->parsers as $parser) {
            $pattern = $parser['pattern'].($caseInsensitive ? 'i' : '');

            $source = $this->searchAndReplace($pattern, $parser['replace'], $source, $parser['callback'] ?? null);
        }

        return $source;
    }

    /**
     * Remove all BBCode.
     *
     * @param  string  $source
     * @return string Parsed text
     */
    public function stripBBCodeTags(string $source)
    {
        $source = e(str_replace("\r\n", "\n", $source));

        foreach ($this->parsers as $parser) {
            $source = $this->searchAndReplace($parser['pattern'].'i', $parser['content'], $source);
        }

        return $source;
    }

    /**
     * Searches after a specified pattern and replaces it with provided structure.
     *
     * @param  string  $pattern  Search pattern
     * @param  string  $replace  Replacement structure
     * @param  string  $source  Text to search in
     * @return string Parsed text
     */
    protected function searchAndReplace(string $pattern, string $replace, string $source, callable $callback = null)
    {
        if ($callback !== null) {
            return preg_replace_callback($pattern, $callback, $source);
        }

        $i = 0;
        while (preg_match($pattern, $source) && $i++ < 10) {
            $source = preg_replace($pattern, $replace, $source);
        }

        return $source;
    }

    /**
     * List of chosen parsers.
     *
     * @return array array of parsers
     */
    public function getParsers()
    {
        return $this->parsers;
    }

    /**
     * Sets the parser pattern and replace.
     * This can be used for new parsers or overwriting existing ones.
     *
     * @param  string  $name  Parser name
     * @param  string  $pattern  Pattern
     * @param  string  $replace  Replace pattern
     * @param  string  $content  Parsed text pattern
     * @return void
     */
    public function addParser(
        string $name,
        string $pattern,
        string $replace,
        string $content,
        callable $callback = null
    ) {
        $this->parsers[$name] = [
            'pattern' => $pattern,
            'replace' => $replace,
            'content' => $content,
            'callback' => $callback,
        ];
    }

    private function handleLink(string $href, string $content)
    {
        if (RegexHelper::isLinkPotentiallyUnsafe($href) || Str::contains($href, '"')) {
            return $content;
        }

        return '<a href="'.$href.'" target="_blank" rel="noopener noreferrer">'.$content.'</a>';
    }

    private function handleImage(string $src, string $alt)
    {
        if ($this->isInternalHost($src)) {
            return '<img src="'.$src.'" alt="'.$alt.'">';
        }

        $safeSrc = str_replace('%s', urlencode($src), $this->imageProxy);

        return '<img src="'.$safeSrc.'" alt="'.e($alt).'" data-original-src="'.e($src).'">';
    }

    private function isInternalHost(string $host)
    {
        if (Str::startsWith($host, '/')) {
            return true;
        }

        foreach ($this->internalHosts as $c) {
            if (strncmp($c, '/', 1) === 0) {
                if (preg_match($c, $host)) {
                    return true;
                }
            } elseif ($c === $host) {
                return true;
            }
        }

        return false;
    }
}
