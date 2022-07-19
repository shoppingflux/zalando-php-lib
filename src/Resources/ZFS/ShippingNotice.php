<?php

namespace ShoppingFlux\Zalando\Resources\ZFS;

use Exception;
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

  const BASE_SHIPPING_NOTICES           = 'zfs/shipping-notices';
  const BASE_ANNOUNCED_ITEM_SETS        = self::BASE_SHIPPING_NOTICES . '/%s/announced-item-sets';
  const BASE_ANNOUNCEMENT_CONFIRMATIONS = self::BASE_SHIPPING_NOTICES . '/%s/announcement-confirmations';
  const BASE_DISPATCH_ITEM_SETS         = self::BASE_SHIPPING_NOTICES . '/%s/dispatch-item-sets';
  const BASE_DISPATCH_CONFIRMATIONS     = self::BASE_SHIPPING_NOTICES . '/%s/dispatch-confirmations';
  const BASE_TOURS                      = 'zfs/tours';

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
    return $this->client->get([self::BASE_SHIPPING_NOTICES]);
  }

  /**
   * @param $id
   * @return mixed
   * @throws Exception
   */
  public function get($id) {
    return $this->client->get([self::BASE_SHIPPING_NOTICES, $id]);
  }

  /**
   * @param $id
   * @return mixed
   * @throws Exception
   */
  public function update($id) {
    return $this->client->put([self::BASE_SHIPPING_NOTICES, $id]);
  }

  /**
   * @param $id
   * @return mixed
   * @throws Exception
   */
  public function listAnnouncedItemSets($id) {
    return $this->client->get([sprintf(self::BASE_ANNOUNCED_ITEM_SETS, $id)]);
  }

  /**
   * @param $id
   * @return mixed
   * @throws Exception
   */
  public function createAnnouncedItemSets($id) {
    return $this->client->post([sprintf(self::BASE_ANNOUNCED_ITEM_SETS, $id)]);
  }

  /**
   * @param $id
   * @param $announcedItemSetID
   * @return mixed
   * @throws Exception
   */
  public function getAnnouncedItemSets($id, $announcedItemSetID) {
    return $this->client->get([sprintf(self::BASE_ANNOUNCED_ITEM_SETS, $id), $announcedItemSetID]);
  }

  /**
   * @param $id
   * @return mixed
   * @throws Exception
   */
  public function createAnnouncementConfirmations($id) {
    return $this->client->get([sprintf(self::BASE_ANNOUNCEMENT_CONFIRMATIONS, $id)]);
  }

  /**
   * @param $id
   * @return mixed
   * @throws Exception
   */
  public function listDispatchItemSets($id) {
    return $this->client->get([sprintf(self::BASE_DISPATCH_ITEM_SETS, $id)]);
  }

  /**
   * @param $id
   * @return mixed
   * @throws Exception
   */
  public function createDispatchItemSets($id) {
    return $this->client->post([sprintf(self::BASE_DISPATCH_ITEM_SETS, $id)]);
  }

  /**
   * @param $id
   * @return mixed
   * @throws Exception
   */
  public function createDispatchConfirmations($id) {
    return $this->client->post([sprintf(self::BASE_DISPATCH_CONFIRMATIONS, $id)]);
  }

  /**
   * @return mixed
   * @throws Exception
   */
  public function listTours() {
    return $this->client->get([sprintf(self::BASE_TOURS)]);
  }
}
