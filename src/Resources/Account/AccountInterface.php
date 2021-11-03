<?php

namespace Worldnet\Resources\Account;

class AccountInterface
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
    $url = "/merchant/api/v1/account/authenticate";
    $api_key = $this->_client->getApiKey();
    $header = ["Authorization: Basic $api_key"];
    $json = $this->_client->get($url, $header);
    $item = json_decode($json);
    $this->_client->setToken($item->token);
    return $item;
  }

}
