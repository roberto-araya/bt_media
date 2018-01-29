<?php

namespace Drupal\bt_media\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class MediaRouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  public function alterRoutes(RouteCollection $collection) {
    // Change path '/media/add' to '/app/website/multimedia/add'.
    if ($route = $collection->get('entity.media.add_page')) {
      $route->setPath('/app/website/multimedia/add');
      $route->setDefault('_title_callback', NULL);
      $route->setDefault('_title', 'Add Multimedia Element');
    }

    // Change path '/media/add/{media_type}' to
    // '/app/website/multimedia/add/{media_type}'.
    if ($route = $collection->get('entity.media.add_form')) {
      $route->setPath('/app/website/multimedia/add/{media_type}');
    }
  }

}
