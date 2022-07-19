<?php

namespace ShoppingFlux\Zalando\Resources\ZFS;

use Exception;
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

  const BASE_LOCATIONS = 'zfs/stock-locations';

  /**
   * Addons constructor.
   * @param Client $client
   */
  public function __construct(Client $client) {
    $this->client = $client;
  }

  /**
   * @return mixed
   * @throws Exception
   */
  public function list() {
    return $this->client->get([self::BASE_LOCATIONS]);
  }

  /**
   * @param $id
   * @return mixed
   * @throws Exception
   */
  public function get($id) {
    return $this->client->get([self::BASE_LOCATIONS, $id]);
  }
}
