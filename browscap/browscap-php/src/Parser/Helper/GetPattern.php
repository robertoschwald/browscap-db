<?php
declare(strict_types = 1);

namespace BrowscapPHP\Parser\Helper;

use BrowscapPHP\Cache\BrowscapCacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * extracts the pattern and the data for theses pattern from the ini content, optimized for PHP 5.5+
 */
class GetPattern implements GetPatternInterface
{
    /**
     * The cache instance
     *
     * @var \BrowscapPHP\Cache\BrowscapCacheInterface
     */
    private $cache;

    /**
     * class contructor
     *
     * @param \BrowscapPHP\Cache\BrowscapCacheInterface $cache
     */
    public function __construct(BrowscapCacheInterface $cache)
    {
        $this->cache = $cache;
    }

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
    public function getPatterns(string $userAgent) : \Generator
    {
        $starts = Pattern::getHashForPattern($userAgent, true);
        $length = strlen($userAgent);

        // add special key to fall back to the default browser
        $starts[] = str_repeat('z', 32);

        // get patterns, first for the given browser and if that is not found,
        // for the default browser (with a special key)
        foreach ($starts as $tmpStart) {
            $tmpSubkey = SubKey::getPatternCacheSubkey($tmpStart);

            try {
                if (! $this->cache->hasItem('browscap.patterns.' . $tmpSubkey, true)) {
                    continue;
                }
            } catch (InvalidArgumentException $e) {
                continue;
            }

            $success = null;

            try {
                $file = $this->cache->getItem('browscap.patterns.' . $tmpSubkey, true, $success);
            } catch (InvalidArgumentException $e) {
                continue;
            }

            if (! $success) {
                continue;
            }

            if (! is_array($file) || ! count($file)) {
                continue;
            }

            $found = false;

            foreach ($file as $buffer) {
                [$tmpBuffer, $len, $patterns] = explode("\t", $buffer, 3);

                if ($tmpBuffer === $tmpStart) {
                    if ($len <= $length) {
                        yield trim($patterns);
                    }

                    $found = true;
                } elseif (true === $found) {
                    break;
                }
            }
        }

        yield '';
    }
}
