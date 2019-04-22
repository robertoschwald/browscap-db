<?php
declare(strict_types = 1);

namespace BrowscapPHP\Parser\Helper;

use BrowscapPHP\Cache\BrowscapCacheInterface;

/**
 * interface for the parser patternHelper
 */
interface GetPatternInterface
{
    /**
     * class contructor
     *
     * @param \BrowscapPHP\Cache\BrowscapCacheInterface $cache
     */
    public function __construct(BrowscapCacheInterface $cache);

    /**
     * Gets some possible patterns that have to be matched against the user agent. With the given
     * user agent string, we can optimize the search for potential patterns:
     * - We check the first characters of the user agent (or better: a hash, generated from it)
     * - We compare the length of the pattern with the length of the user agent
     *   (the pattern cannot be longer than the user agent!)
     *
     * @param string $userAgent
     *
     * @return \Generator
     */
    public function getPatterns(string $userAgent) : \Generator;
}
