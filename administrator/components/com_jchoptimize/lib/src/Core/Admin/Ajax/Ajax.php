<?php

/**
 * JCH Optimize - Performs several front-end optimizations for fast downloads.
 *
 * @author    Samuel Marshall <samuel@jch-optimize.net>
 * @copyright Copyright (c) 2022 Samuel Marshall / JCH Optimize
 * @license   GNU/GPLv3, or later. See LICENSE file
 *
 *  If LICENSE file missing, see <http://www.gnu.org/licenses/>.
 */

namespace JchOptimize\Core\Admin\Ajax;

use _JchOptimizeVendor\Joomla\DI\ContainerAwareInterface;
use _JchOptimizeVendor\Joomla\DI\ContainerAwareTrait;
use JchOptimize\ContainerFactory;
use JchOptimize\Core\Admin\Json;
use Joomla\Input\Input;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

\defined('_JCH_EXEC') or exit('Restricted access');
abstract class Ajax implements ContainerAwareInterface, LoggerAwareInterface
{
    use ContainerAwareTrait;
    use LoggerAwareTrait;

    protected Input $input;

    private function __construct()
    {
        \ini_set('pcre.backtrack_limit', '1000000');
        \ini_set('pcre.recursion_limit', '1000000');
        if (!\JCH_DEVELOP) {
            \error_reporting(0);
        }
        if (\version_compare(\PHP_VERSION, '7.0.0', '>=')) {
            \ini_set('pcre.jit', '0');
        }
        $this->container = ContainerFactory::getContainer();
        $this->logger = $this->container->get(LoggerInterface::class);
        $this->input = $this->container->get(Input::class);
    }

    public static function getInstance(string $sClass): Ajax
    {
        $sFullClass = '\\JchOptimize\\Core\\Admin\\Ajax\\'.$sClass;
        // @var Ajax
        return new $sFullClass();
    }

    /**
     * @return Json|string
     */
    abstract public function run();
}
