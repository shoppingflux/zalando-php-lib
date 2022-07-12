<?php

namespace ShoppingFlux\Zalando\Resources\ZFS;

use ShoppingFlux\Zalando\Client;

/**
 * Class StockMovements
 * @package ShoppingFlux\Zalando\Resources\ZFS
 *
 * @see https://developers.merchants.zalando.com/docs/stock-movements-api.html
 * @see https://developers.merchants.zalando.com/docs/openapi/stock-movements.html
 *
 * @property Client $client
 */
class StockMovements {

  const BASE_RETURNED         = 'zfs/returned-items';
  const BASE_RECEIVED         = 'zfs/received-items';
  const BASE_INTRA_COMMUNITY  = 'zfs/intra-community-movements';

  /**
   * Addons constructor.
   * @param Client $client
   */
  public function __construct(Client $client) {
    $this->client = $client;
  }
}
