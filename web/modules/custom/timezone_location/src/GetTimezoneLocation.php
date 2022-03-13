<?php

namespace Drupal\timezone_location;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Datetime\DateFormatter;

/**
 * Get Date using timezone service class.
 */
class GetTimezoneLocation {
  /**
   * The datetime.time service.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $timeService;

  /**
   * The Date Fromatter.
   *
   * @var Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;

  /**
   * {@inheritDoc}
   */
  public function __construct(TimeInterface $time_service, DateFormatter $dateFormatter) {
    $this->timeService = $time_service;
    $this->dateFormatter = $dateFormatter;
  }

  /**
   * Create User.
   */
  public function getCurrentDateTime($timezone) {
    $current_time = $this->timeService->getCurrentTime();
    $date_time = $this->dateFormatter->format($current_time, 'custom', 'd\\t\\h M Y - h:i A', $timezone);
    return $date_time;
  }

}
