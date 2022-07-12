<?php

namespace ShoppingFlux\Zalando\Resources\ZFS;

use ShoppingFlux\Zalando\Client;

/**
 * Class StockLocations
 * @package ShoppingFlux\Zalando\Resources\ZFS
 *
 * @see https://developers.merchants.zalando.com/docs/zfs-stock-locations-api.html
 * @see https://developers.merchants.zalando.com/docs/openapi/stock-locations.html
 *
 * @property Client $client
 */
class StockLocations {

  const BASE = 'zfs/stock-locations';

  /**
   * Addons constructor.
   * @param Client $client
   */
  public function __construct(Client $client) {
    $this->client = $client;
  }
}
