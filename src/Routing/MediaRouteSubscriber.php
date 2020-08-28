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
    // Change path '/media/add' to '/app/website/media/add'.
    if ($route = $collection->get('entity.media.add_page')) {
      $route->setPath('/app/website/media/add');
      $route->setDefault('_title_callback', NULL);
      $route->setDefault('_title', 'Add Multimedia Element');
      $route->setDefault('_controller', '\Drupal\bt_media\Controller\CustomMediaEntityController::addPage');
    }

    // Change path '/media/add/{media_type}' to
    // '/app/website/media/add/{media_type}'.
    if ($route = $collection->get('entity.media.add_form')) {
      $route->setPath('/app/website/media/add/{media_type}');
    }

    // Change path '/admin/content/media' to
    // '/app/website/media'.
    if ($route = $collection->get('entity.media.collection')) {
      $route->setPath('/app/website/media');
      $route->setOption('_admin_route', TRUE);
    }

    if ($route = $collection->get('view.media_library.page')) {
      // $route->setPath('/app/website/media');
      $route->setOption('_admin_route', TRUE);
    }
  }

}
