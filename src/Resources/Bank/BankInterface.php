<?php

namespace Worldnet\Resources\Bank;

class BankInterface
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

  public function transfer()
  {
    $url = "/merchant/api/v1/account/authenticate";
    $api_key = $this->_client->getApiKey();
    $header = ["Authorization: Basic $api_key"];
    $json = $this->_client->get($url, $header);
    $item = json_decode($json);
    $this->_client->setToken($item->token);
    return $item;
  }

}
