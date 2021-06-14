<?php

namespace Drupal\kadabrait_content;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Postservice es un simple servicio de prueba.
 */
class PostService {

  /**
   * The entity storage for views.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * The field storage.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new Storage Injection.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager.
   * @param \Drupal\Core\Session\AccountInterface $currentUser
   *   The account interface.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager, AccountInterface $currentUser) {
    $this->entityTypeManager = $entityTypeManager;
    $this->currentUser = $currentUser;
  }

  /**
   * Funcion para obtener los nodos.
   */
  public function getLastPosts($count) {
    $storage = $this->entityTypeManager
      ->getStorage('node')
      ->getQuery()
      ->sort('nid', 'DESC')
      ->condition('uid', $this->currentUser->id(), "")
      ->range(0, $count)
      ->execute();
    $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($storage);
    $list = [];
    foreach ($nodes as $n) {
      $list[] = $n->toLink($n->getTitle())->toRenderable();
    }
    return $list;
  }

}
