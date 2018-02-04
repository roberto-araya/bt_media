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
  private $routes = [
    'entity.media.add_form',
    'entity.media.add_page',
    'entity.media.edit_form',
    'page_manager.page_view_app_website_media_app_website_media-panels_variant-0',
    'page_manager.page_view_app_website_media_app_website_media-panels_variant-1',
  ];

  /**
   * {@inheritdoc}
   */
  public function __construct(ConfigFactory $configFactory) {
    $this->siteName = $configFactory->get('system.site')->get('name');
  }

  /**
   * {@inheritdoc}
   */
  public function applies(RouteMatchInterface $routeMatch) {
    $match = $this->routes;
    if (in_array($routeMatch->getRouteName(), $match)) {
      if ($routeMatch->getRouteName() == 'entity.media.add_form') {
        if ($routeMatch->getParameters()->get('media_type')->get('id') != 'bt_documents') {
          return TRUE;
        }
        else {
          return FALSE;
        }
      }
      elseif ($routeMatch->getRouteName() == 'entity.media.edit_form') {
        if ($routeMatch->getParameters()->get('media')->bundle() != 'bt_documents') {
          return TRUE;
        }
        else {
          return FALSE;
        }
      }
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function build(RouteMatchInterface $routeMatch) {
    $route = $routeMatch->getRouteName();
    $breadcrumb = new Breadcrumb();
    $breadcrumb->addCacheContexts(["url"]);

    $breadcrumb->addLink(Link::createFromRoute($this->siteName, 'page_manager.page_view_app_app-panels_variant-0'));
    $breadcrumb->addLink(Link::createFromRoute('Website', 'page_manager.page_view_app_website_app_website-panels_variant-0'));

    if (in_array($route, [
      'entity.media.add_page',
      'entity.media.edit_form',
      'entity.media.add_form',
    ])) {
      $breadcrumb->addLink(Link::createFromRoute('Media', 'page_manager.page_view_app_website_media_app_website_media-panels_variant-0'));
      if ($route == 'entity.media.add_form') {
        $breadcrumb->addLink(Link::createFromRoute('Add media', 'entity.media.add_page'));
      }
    }

    return $breadcrumb;
  }

}
