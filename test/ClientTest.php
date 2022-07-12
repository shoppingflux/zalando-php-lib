<?php

namespace ShoppingFlux\Zalando\Test;

use ShoppingFlux\Zalando\Client;
use PHPUnit\Framework\TestCase;
use Exception;

class ClientTest extends TestCase {

  /**
   * @throws Exception
   */
  protected function setUp(): void {
    parent::setUp();

    $this->client = new Client('', '', '');
  }

  /**
   * @throws Exception
   */
  public function testServiceStatus() {
  }
}
