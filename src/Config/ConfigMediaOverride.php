<?php
/**
 *
 */

namespace Drupal\bt_media\Config;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Config\ConfigFactoryOverrideInterface;

/**
 * Example configuration override.
 */
class ConfigMediaOverride implements ConfigFactoryOverrideInterface {

    public function loadOverrides($names) {
        $overrides = array();

        if (in_array('core.entity_view_mode.media.slick', $names)) {
            $overrides['core.entity_view_mode.media.slick']['label'] = 'Slideshow';
        }
        if (in_array('core.entity_view_mode.media.library_thumbnail', $names)) {
            $overrides['core.entity_view_mode.media.library_thumbnail']['label'] = 'Miniature';
        }

        return $overrides;
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheSuffix() {
        return 'ConfigMediaOverride';
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheableMetadata($name) {
        return new CacheableMetadata();
    }

    /**
     * {@inheritdoc}
     */
    public function createConfigObject($name, $collection = StorageInterface::DEFAULT_COLLECTION) {
        return NULL;
    }
}