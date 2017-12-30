<?php

namespace Drupal\bt_media\Controller;

use Drupal\Core\Entity\Controller\EntityController;

/**

 */
class CustomMediaEntityController extends EntityController {

  /**
   * Alter list excluding instagram, bt_documents adn tweet
   */
  public function addPage($entity_type_id) {
    $build = parent::addPage($entity_type_id);
    unset($build['#bundles']['instagram']);
    unset($build['#bundles']['tweet']);
    //unset($build['#bundles']['bt_documents']);
    //ksm($build);
    return $build;
  }
}
