<?php

namespace Worldnet\Resources\Transaction;

class TransactionInterface
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

  public function search($terminal, $filter = [])
  {
    $filter['terminal'] = $terminal;
    if(!array_key_exists('pageSize', $filter)){
      $filter['pageSize'] = 100;
    }
    $url = "/merchant/api/v1/transaction/transactions";
    $token = $this->_client->getToken();
    $header = ["Content-Type: application/json", "Authorization: Bearer $token"];
    $json = $this->_client->get($url, $header, $filter);
    return json_decode($json);
  }

  public function get($uniqueRef)
  {
    $url = sprintf("/merchant/api/v1/transaction/payments/%s", $uniqueRef);
    $token = $this->_client->getToken();
    $header = ["Content-Type: application/json", "Authorization: Bearer $token"];
    $json = $this->_client->get($url, $header);
    return json_decode($json);
  }

  public function create($data = [])
  {
    $url = "/merchant/api/v1/transaction/payments";
    $token = $this->_client->getToken();
    $header = ["Content-Type: application/json", "Authorization: Bearer $token"];
    $json = $this->_client->post($url, $header, $data);
    return json_decode($json);
  }

  public function update($uniqueRef, $data = [])
  {
    $url = sprintf("/merchant/api/v1/transaction/payments/%s", $uniqueRef);
    $token = $this->_client->getToken();
    $header = ["Content-Type: application/json", "Authorization: Bearer $token"];
    $json = $this->_client->patch($url, $header, $data);
    return json_decode($json);
  }

}


