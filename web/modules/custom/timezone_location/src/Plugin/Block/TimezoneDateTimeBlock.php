<?php

namespace Drupal\timezone_location\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'TimezoneDateTime' block.
 *
 * @Block(
 *  id = "timezone_location_block",
 *  admin_label = @Translation("Timezone DateTime Block"),
 * )
 */
class TimezoneDateTimeBlock extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * Drupal\timezone_location\GetTimezoneLocation definition.
   *
   * @var \Drupal\timezone_location\GetTimezoneLocation
   */

  protected $timezoneLocation;

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a timezone_location object.
   *
   * @param array $configuration
   *   The configuration.
   * @param string $plugin_id
   *   The plugin_id.
   * @param mixed $plugin_definition
   *   The plugin_definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   Config factory.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = new static($configuration, $plugin_id, $plugin_definition, $container->get('config.factory'));
    $instance->timezoneLocation = $container->get('timezone_location.timezone_location_time');
    return $instance;
  }

  /**
   * The getCacheMaxAge.
   */
  public function getCacheMaxAge() {
    return 0;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = $timeset = [];
    $config = $this->configFactory->get('timezone_location.settings');
    $timzone = $config->get('timezone_list');
    $dateTimeValue = $this->timezoneLocation->getCurrentDateTime($timzone);
    $build['#theme'] = 'timezone_datetime_block';
    $timeset = [
      'timezone' => $timzone,
      'datetime' => $dateTimeValue,
    ];
    $build['#data'] = $timeset;
    return $build;
  }

}
