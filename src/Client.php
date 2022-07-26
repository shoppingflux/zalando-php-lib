<?php

namespace ShoppingFlux\Zalando;

use Exception;
use ShoppingFlux\Zalando\Resources\ZFS\ItemQuantities;
use ShoppingFlux\Zalando\Resources\ZFS\ShippingNotice;
use ShoppingFlux\Zalando\Resources\ZFS\StockLocations;
use ShoppingFlux\Zalando\Resources\ZFS\StockMovements;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

/**
 * Class Client
 * @package ShoppingFlux\Zalando
 *
 * @property ItemQuantities $itemQuantities
 * @property ShippingNotice $shippingNotice
 * @property StockLocations $stockLocations
 * @property StockMovements $stockMovements
 */
class Client {

  /**
   * @see https://developers.merchants.zalando.com/docs/api-overview.html#base-urls
   */
  const SANDBOX_URL     = 'https://api-sandbox.merchants.zalando.com';
  const PRODUCTION_URL  = 'https://api.merchants.zalando.com';

  /**
   * @var string $baseUrl
   */
  private $baseUrl;

  /**
   * @var $requestHeader
   */
  private $requestHeader;

  /**
   * @var $curlClient
   */
  private $curlClient;

  /**
   * @var string $clientID
   */
  private $clientID;

  /**
   * @var string $clientSecret
   */
  private $clientSecret;

  /**
   * @var string $merchantID
   */
  private $merchantID;

  /**
   * @var string $accessToken
   */
  private $accessToken;

  /**
   * @var string $etag
   */
  private $etag;

  /**
   * @var bool $sandbox
   */
  private $isSandbox;

  /**
   * Client constructor.
   * @param $merchantID
   * @param $clientID
   * @param $clientSecret
   * @param $accessToken
   * @param bool $isSandbox
   */
  public function __construct($merchantID, $clientID, $clientSecret, $accessToken = null, bool $isSandbox = false) {
    // Init the Curl Client
    $this->curlClient = curl_init();

    // Init the infos
    $this->merchantID   = $merchantID;
    $this->clientID     = $clientID;
    $this->clientSecret = $clientSecret;
    $this->accessToken  = $accessToken;
    $this->isSandbox    = $isSandbox;

    // Init the Base URL and Auth
    $this->initBaseURL();

    // Refresh the token (if none provided, otherwise use that one)
    if (!$accessToken) $this->refreshToken();

    // Init the resources
    $this->itemQuantities = new ItemQuantities($this);
    $this->shippingNotice = new ShippingNotice($this);
    $this->stockLocations = new StockLocations($this);
    $this->stockMovements = new StockMovements($this);
  }

  /**
   * @return string
   */
  public function getMerchantID(): string {
    return $this->merchantID;
  }

  /**
   * @return string
   */
  public function getAccessToken(): string {
    return $this->accessToken;
  }

  /**
   * @return string
   */
  public function getETag(): string {
    return $this->etag;
  }

  /**
   * Init the Base URL (production or sandbox)
   * @return void
   */
  private function initBaseURL() {
    $this->baseUrl = $this->isSandbox ? self::SANDBOX_URL : self::PRODUCTION_URL;
  }

  /**
   * Auth the account using the ClientID and ClientSecret to retrieve the token
   * @return void
   */
  protected function refreshToken() {
    // Init the Curl Client
    $this->curlClient = curl_init();

    // Generate the Auth info
    curl_setopt($this->curlClient, CURLOPT_URL, $this->baseUrl . '/auth/token');
    curl_setopt($this->curlClient, CURLOPT_HEADER, false);
    curl_setopt($this->curlClient, CURLOPT_NOBODY, false);
    curl_setopt($this->curlClient, CURLOPT_HTTPHEADER, ["Content-Type: application/x-www-form-urlencoded"]);
    curl_setopt($this->curlClient, CURLOPT_USERPWD, $this->clientID . ":" . $this->clientSecret);
    curl_setopt($this->curlClient, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($this->curlClient, CURLOPT_POST, true);
    curl_setopt($this->curlClient, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

    // Execute the query and retrieves the response
    $response = json_decode(curl_exec($this->curlClient));
    $httpCode = curl_getinfo($this->curlClient, CURLINFO_HTTP_CODE);

    // Close the connection
    curl_close($this->curlClient);

    // Throw error if "429 - Too Many Requests"
    if ($httpCode == 429) throw new TooManyRequestsHttpException;

    // Store the accessToken
    $this->accessToken = $response->access_token;

    // If everything went ok (200), we send the response with token and expiration
    return $response;
  }

  /**
   * @param string $method
   * @param array $path
   * @param array $query
   * @param array $params
   * @return mixed
   */
  protected function request(string $method, array $path, array $query = [], array $params = []) {
    // Init the Curl Client
    $this->curlClient = curl_init();

    // Add query params
    $reqPath = implode('/', $path);
    if (!empty($query)) {
      $path .= '?' . http_build_query($query);
    }

    // Headers
    $headers = [
      'Content-Type: application/json',
      'Authorization: Bearer ' . $this->accessToken
    ];

    // Append etag
    if ($this->etag) $headers[] = 'If-Match: ' . $this->etag;

    // Set the request params
    curl_setopt($this->curlClient, CURLOPT_URL, $this->baseUrl . '/' . $reqPath);
    curl_setopt($this->curlClient, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($this->curlClient, CURLOPT_HEADER, true);
    curl_setopt($this->curlClient, CURLOPT_NOBODY, false);
    curl_setopt($this->curlClient, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($this->curlClient, CURLOPT_HTTPHEADER, $headers);

    // Add params if any
    if (!empty($params)) {
      curl_setopt($this->curlClient, CURLOPT_POST, true);
      curl_setopt($this->curlClient, CURLOPT_POSTFIELDS, json_encode($params));
    }

    // Return headers separately from the Response Body
    $body       = curl_exec($this->curlClient);
    $headerSize = curl_getinfo($this->curlClient, CURLINFO_HEADER_SIZE);
    $httpCode   = curl_getinfo($this->curlClient, CURLINFO_HTTP_CODE);
    $header     = $this->headerToArray(substr($body, 0, $headerSize));
    $response   = json_decode(substr($body, $headerSize));

    // If there's a token and an unhauthorized error is given, we refresh the token and try again
    if ($httpCode == 401 && $this->accessToken) {
      $this->refreshToken();
      return $this->request($method, $path, $query, $params);
    }
    
    // Store the etag if retrieved in the headers
    if (isset($header['etag'])) $this->etag = $header['etag'];

    // Close the connection
    curl_close($this->curlClient);

    // Return the response
    return $response;
  }

  /**
   * GET Method
   *
   * @param array $base
   * @param array $query
   * @param array $params
   * @return mixed
   * @throws Exception
   */
  public function get(array $base, array $query = [], array $params = []) {
    return $this->request('GET', $base, $this->wrap($query), $this->wrap($params));
  }

  /**
   * POST Method
   *
   * @param array $base
   * @param array $query
   * @param array $params
   * @return mixed
   * @throws Exception
   */
  public function post(array $base, array $query = [], array $params = []) {
    return $this->request('POST', $base, $this->wrap($query), $this->wrap($params));
  }

  /**
   * PUT Method
   *
   * @param array $base
   * @param array $query
   * @param array $params
   * @return mixed
   * @throws Exception
   */
  public function put(array $base, array $query = [], array $params = []) {
    return $this->request('PUT', $base, $this->wrap($query), $this->wrap($params));
  }

  /**
   * DELETE Method
   *
   * @param array $base
   * @param array $query
   * @param array $params
   * @return mixed
   * @throws Exception
   */
  public function delete(array $base, array $query = [], array $params = []) {
    return $this->request('DELETE', $base, $this->wrap($query), $this->wrap($params));
  }

  /**
   * If the given value is not an array, wrap it in one.
   *
   * @param  mixed  $value
   * @return array
   */
  private function wrap($value): array {
    return !is_array($value) ? [$value] : $value;
  }

  /**
   * Convert the header into an array
   * @see https://stackoverflow.com/a/44698478
   * @param $header
   * @return array
   */
  private function headerToArray($header): array {
    foreach(explode("\r\n", $header) as $row) {
      if (preg_match('/(.*?): (.*)/', $row, $matches)) {
        $headers[$matches[1]] = $matches[2];
      }
    }

    // Return the header as an array
    return $headers;
  }
}
