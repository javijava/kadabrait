<?php

namespace Drupal\kadabrait_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\kadabrait_content\PostService;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "kadabrait_content_example",
 *   admin_label = @Translation("Kadabrait Posts Block"),
 *   category = @Translation("Kadabrait Posts Block")
 * )
 */
class KadabraitPostsBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * PostService.
   *
   * @var Drupal\kadabrait_content\PostService
   */
  protected $postservice;

  /**
   * Function Constructur.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, PostService $service) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->postservice = $service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('kadabrait_content.post')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $output = $this->postservice->getLastPosts(3);
    $build['content'] = [
      '#theme' => 'kadabrait',
      '#nodes' => $output,
    ];

    return $build;
  }

}
