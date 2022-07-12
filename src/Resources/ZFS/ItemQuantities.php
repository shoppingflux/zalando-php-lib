<?php

namespace ShoppingFlux\Zalando\Resources\ZFS;

use Exception;
use ShoppingFlux\Zalando\Client;

/**
 * Class ItemQuantities
 * @package ShoppingFlux\Zalando\Resources\ZFS
 *
 * @see https://developers.merchants.zalando.com/docs/item-quantities-api.html
 * @see https://developers.merchants.zalando.com/docs/openapi/item-quantities.html
 *
 * @property Client $client
 */
class ItemQuantities {

  const BASE_ITEM_QUANTITIES = 'zfs/item-quantities';
  const BASE_ITEM_SNAPSHOTS  = 'zfs/item-quantity-snapshots';

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
  public function get() {
    return $this->client->get([self::BASE_ITEM_QUANTITIES, $this->client->getMerchantID()]);
  }

  /**
   * @return mixed
   * @throws Exception
   */
  public function getSnapshots() {
    return $this->client->get([self::BASE_ITEM_SNAPSHOTS, $this->client->getMerchantID()]);
  }
}
