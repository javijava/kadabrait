<?php

namespace Drupal\kadabrait_content\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\kadabrait_content\PostService;

/**
 * Returns responses for kadabrait_content routes.
 */
class KadabraitContentController extends ControllerBase {

  /**
   * The entity storage for views.
   *
   * @var \Drupal\kadabrait_content\PostService
   */

  protected $postservice;

  /**
   * Function Constructur.
   */
  public function __construct(PostService $service) {
    // $this->currentUser = $current_user;
    $this->postservice = $service;
  }

  /**
   * Function create.
   */
  public static function create(ContainerInterface $container) {
    return new static(
    // $container->get('current_user'),
      $container->get('kadabrait_content.post')
    );
  }

  /**
   * Builds the response.
   */
  public function build() {
    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

  /**
   * Function todos.
   */
  public function todos() {

    $output = $this->postservice->getLastPosts(10);
    $build['content'] = [
      '#theme' => 'kadabrait',
      '#nodes' => $output,
    ];

    return $build;
  }

}
