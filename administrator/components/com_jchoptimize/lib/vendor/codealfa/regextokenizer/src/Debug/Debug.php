<?php

/**
 * @author    Samuel Marshall <sdmarshall73@gmail.com>
 * @copyright Copyright (c) 2020 Samuel Marshall
 * @license   GNU/GPLv3, or later. See LICENSE file
 *
 * If LICENSE file missing, see <http://www.gnu.org/licenses/>.
 */

namespace CodeAlfa\RegexTokenizer\Debug;

use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Trait Debug  - To use the Debug trait you must add a PSR-3 compliant Logger to the class using this trait.
 */
trait Debug
{
    use LoggerAwareTrait;
    // DO NOT ENABLE on production sites!!
    public $_debug = \false;
    public $_limit = 10.0;
    public $_printCode = \true;

    /**
     * @param mixed $regexNum
     */
    public function _debug(string $regex, string $code, $regexNum = 0): void
    {
        if (!$this->_debug) {
            return;
        }
        if (\is_null($this->logger)) {
            $this->setLogger(new NullLogger());
        }
        \assert($this->logger instanceof LoggerInterface);

        /** @var float $pstamp */
        static $pstamp = 0.0;
        if (0.0 === $pstamp) {
            $pstamp = \microtime(\true);

            return;
        }
        $nstamp = \microtime(\true);
        $time = ($nstamp - $pstamp) * 1000;
        if ($time > $this->_limit) {
            $context = ['category' => 'Regextokenizer'];
            $this->logger->debug('regexNum = '.(string) $regexNum, $context);
            $this->logger->debug('time = '.(string) $time, $context);
            if ($this->_printCode) {
                $this->logger->debug('regex = '.$regex, $context);
                $this->logger->debug('code = '.$code, $context);
            }
        }
        $pstamp = $nstamp;
    }
}
