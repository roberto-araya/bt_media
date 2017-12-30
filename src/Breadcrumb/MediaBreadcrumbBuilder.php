<?php

namespace Drupal\bt_media\Breadcrumb;

use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Session\AccountProxy;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Link;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\Entity\User;

class MediaBreadcrumbBuilder implements BreadcrumbBuilderInterface {

    /**
     * @var AccountInterface
     */
    protected $account;

    /**
     * The routes that will change their breadcrumbs.
     */
    private $routes = array(
        //'entity.node.edit_form',
        //'node.add',
        //'page_manager.page_view_bt_add_gallery',
        //'page_manager.page_view_bt_add_image',
        //'page_manager.page_view_bt_add_slideshow',
        //'page_manager.page_view_bt_add_video',
        //'node.add_page',
        'entity.media.add_page',
        'entity.media.edit_form',
        //'bt_add_block',
        //'block_content.add_form',
        //'page_manager.page_view_app_app-panels_variant-0',
        //'page_manager.page_view_app_website_app_website-panels_variant-0',
        //'page_manager.page_view_app_website_content_app_website_content-panels_variant-0',
        //'page_manager.page_view_app_website_content_app_website_content-panels_variant-1',
        //'page_manager.page_view_app_website_comments',
        //'page_manager.page_view_app_website_documents_app_website_documents-panels_variant-0',
        //'page_manager.page_view_app_website_documents_app_website_documents-panels_variant-1',
        'page_manager.page_view_app_website_media_app_website_media-panels_variant-0',
        'page_manager.page_view_app_website_media_app_website_media-panels_variant-1',
        //'page_manager.page_view_app_website_polls_app_website_polls-panels_variant-0',
        //'page_manager.page_view_app_website_foros_app_website_foros-panels_variant-0',
        //'page_manager.page_view_app_website_blocks_app_website_blocks-panels_variant-0',
        //'poll.poll_add',
        //'entity.poll.edit_form',
        //'bt_page_drag_and_drop',
        //'page_manager.page_view_bt_upload_document',
        //'bt_create_ipe_page',
        //'bt_edit_ipe_page',
        //'bt_delete_ipe_page',
    );

    /**
     * Class constructor.
     */
    public function __construct(AccountProxy $current_user) {
        $user_id = $current_user->id();
        $user_account = User::load($user_id);
        $this->account = $user_account;
    }

    /**
    * {@inheritdoc}
    */
    public function applies(RouteMatchInterface $attributes) {
        $match = $this->routes;
        if (in_array($attributes->getRouteName(),$match)) {
            return TRUE;
        }else{
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
        $site_name = \Drupal::config('system.site')->get('name');

        $breadcrumb->addLink(Link::createFromRoute($site_name, 'page_manager.page_view_app_app-panels_variant-0'));
        $breadcrumb->addLink(Link::createFromRoute('Website', 'page_manager.page_view_app_website_app_website-panels_variant-0'));

        switch ($route) {
            case 'entity.media.add_page':
                $breadcrumb->addLink(Link::createFromRoute('Multimedia', 'page_manager.page_view_app_website_media_app_website_media-panels_variant-0'));
                break;
            case 'entity.media.edit_form':
                $mid = $route_match->getParameters()->get('media')->bundle();
                if ($mid == 'bt_documents') {
                    $breadcrumb->addLink(Link::createFromRoute('Documents', 'page_manager.page_view_app_website_documents_app_website_documents-panels_variant-0'));
                }else{
                    $breadcrumb->addLink(Link::createFromRoute('Multimedia', 'page_manager.page_view_app_website_media_app_website_media-panels_variant-0'));
                }
                break;
        }
        return $breadcrumb;
    }
}