<?php
/**
* @file
* Contains \Drupal\bt_cms\Routing\RouteSubscriber.
*/
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
            //$route->setDefault('_controller','\Drupal\bt_media\Controller\CustomMediaEntityController::addPage');
            $route->setDefault('_title_callback', NULL);
            $route->setDefault('_title','Add Multimedia Element');
        }

        // Change path '/media/add/{media_bundle}' to '/app/website/multimedia/add/{media_bundle}'.
        if ($route = $collection->get('entity.media.add_form')) {
            $route->setPath('/app/website/multimedia/add/{media_bundle}');
        }
    }
}
