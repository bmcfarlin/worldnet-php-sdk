<?php

namespace Worldnet\Resources\Boarding;

class BoardingInterface
{

  private $_client;

  function __construct($client)
  {
    $this->_client = $client;
  }

  function __toString()
  {
    return get_class($this);
  }

  public function authenticate()
  {
    $url = "/merchant/api/v2/boarding/authenticate";
    $api_key = $this->_client->getApiKey();
    $header = ["Authorization: Basic $api_key"];
    $json = $this->_client->get($url, $header);
    $item = json_decode($json);
    $this->_client->setBToken($item->token);
    return $item;
  }

}
