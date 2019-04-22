<?php
declare(strict_types = 1);

namespace BrowscapPHP\Parser\Helper;

use BrowscapPHP\Cache\BrowscapCacheInterface;
use BrowscapPHP\Helper\QuoterInterface;

/**
 * interface for the parser dataHelper
 */
interface GetDataInterface
{
    /**
     * class contsructor
     *
     * @param \BrowscapPHP\Cache\BrowscapCacheInterface $cache
     * @param \BrowscapPHP\Helper\QuoterInterface       $quoter
     */
    public function __construct(BrowscapCacheInterface $cache, QuoterInterface $quoter);

    /**
     * Gets the settings for a given pattern (method calls itself to
     * get the data from the parent patterns)
     *
     * @param  string $pattern
     * @param  array  $settings
     *
     * @throws \UnexpectedValueException
     *
     * @return array
     */
    public function getSettings(string $pattern, array $settings = []) : array;
}
