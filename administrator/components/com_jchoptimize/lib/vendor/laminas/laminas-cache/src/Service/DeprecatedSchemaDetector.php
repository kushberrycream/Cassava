<?php

declare(strict_types=1);

namespace _JchOptimizeVendor\Laminas\Cache\Service;

/**
 * @internal
 */
final class DeprecatedSchemaDetector implements DeprecatedSchemaDetectorInterface
{
    public function isDeprecatedStorageFactorySchema(array $configuration): bool
    {
        if (!\is_string($configuration['adapter'])) {
            return \true;
        }
        if (!isset($configuration['plugins'])) {
            return \false;
        }
        if (!\is_array($configuration['plugins'])) {
            return \true;
        }
        foreach ($configuration['plugins'] as $index => $plugin) {
            if (\is_string($index) || !\is_array($plugin)) {
                return \true;
            }
            if (!isset($plugin['name'])) {
                return \true;
            }
        }

        return \false;
    }
}
