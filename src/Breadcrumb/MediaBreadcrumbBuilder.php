<?php

namespace Drupal\bt_media\Breadcrumb;

use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Link;
use Drupal\Core\Config\ConfigFactory;

/**
 * Class MediaBreadcrumbBuilder.
 */
class MediaBreadcrumbBuilder implements BreadcrumbBuilderInterface {

  /**
   * The site name.
   *
   * @var string
   */
  protected $siteName;

  /**
   * The routes that will change their breadcrumbs.
   *
   * @var array
   */
  private $routes = array(
    'entity.media.add_page',
    'entity.media.edit_form',
    'page_manager.page_view_app_website_media_app_website_media-panels_variant-0',
    'page_manager.page_view_app_website_media_app_website_media-panels_variant-1',
  );

  /**
   * {@inheritdoc}
   */
  public function __construct(ConfigFactory $configFactory) {
    $this->siteName = $configFactory->get('system.site')->get('name');
  }

  /**
   * {@inheritdoc}
   */
  public function applies(RouteMatchInterface $attributes) {
    $match = $this->routes;
    if (in_array($attributes->getRouteName(), $match)) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function build(RouteMatchInterface $route_match) {
    $route = $route_match->getRouteName();
    $breadcrumb = new Breadcrumb();
    $breadcrumb->addCacheContexts(["url"]);

    $breadcrumb->addLink(Link::createFromRoute($this->siteName, 'page_manager.page_view_app_app-panels_variant-0'));
    $breadcrumb->addLink(Link::createFromRoute('Website', 'page_manager.page_view_app_website_app_website-panels_variant-0'));

    switch ($route) {
      case 'entity.media.add_page':
        $breadcrumb->addLink(Link::createFromRoute('Multimedia', 'page_manager.page_view_app_website_media_app_website_media-panels_variant-0'));
        break;

      case 'entity.media.edit_form':
        $mid = $route_match->getParameters()->get('media')->bundle();
        if ($mid == 'bt_documents') {
          $breadcrumb->addLink(Link::createFromRoute('Documents', 'page_manager.page_view_app_website_documents_app_website_documents-panels_variant-0'));
        }
        else {
          $breadcrumb->addLink(Link::createFromRoute('Multimedia', 'page_manager.page_view_app_website_media_app_website_media-panels_variant-0'));
        }
        break;

    }

    return $breadcrumb;
  }

}
