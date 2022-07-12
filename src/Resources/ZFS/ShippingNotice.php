<?php

namespace ShoppingFlux\Zalando\Resources\ZFS;

use ShoppingFlux\Zalando\Client;

/**
 * Class ShippingNotice
 * @package ShoppingFlux\Zalando\Resources\ZFS
 *
 * @see https://developers.merchants.zalando.com/docs/shipping-notices-api.html
 * @see https://developers.merchants.zalando.com/docs/openapi/shipping-notices.html
 *
 * @property Client $client
 */
class ShippingNotice {

  const BASE = 'zfs/shipping-notices';
  const BASE_TOURS = 'zfs/tours';

  /**
   * Addons constructor.
   * @param Client $client
   */
  public function __construct(Client $client) {
    $this->client = $client;
  }
}
