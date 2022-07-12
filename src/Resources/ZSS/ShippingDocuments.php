<?php

namespace ShoppingFlux\Zalando\Resources\ZSS;

use ShoppingFlux\Zalando\Client;

/**
 * Class ShippingDocuments
 * @package ShoppingFlux\Zalando\Resources\ZSS
 *
 * @see https://developers.merchants.zalando.com/docs/zss-shipping-documents-api.html
 * @see https://developers.merchants.zalando.com/docs/openapi/shipping-documents.html
 *
 * @property Client $client
 */
class ShippingDocuments {

  const BASE = 'zss/shipping-documents';

  /**
   * Addons constructor.
   * @param Client $client
   */
  public function __construct(Client $client) {
    $this->client = $client;
  }
}
