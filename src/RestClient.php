<?php

namespace Worldnet;

class RestClient
{
  private $_api_key;
  private $_base_url;
  private $_token;

  function __construct($api_key = null, $base_url = null)
  {
    if(empty($api_key))
    {
      $api_key = getenv('WORLDNET_API_KEY');
    }

    if(empty($base_url))
    {
      $base_url = getenv('WORLDNET_API_URL');
    }

    $this->_api_key = $api_key;
    $this->_base_url = $base_url;
  }

  function __toString()
  {
    return get_class($this);
  }

  function getApiKey()
  {
    return $this->_api_key;
  }

  function getBaseUrl()
  {
    return $this->_base_url;
  }

  function setToken($token)
  {
    $this->_token = $token;
  }

  function getToken()
  {
    return $this->_token;
  }

  function get($path, $header = [], $payload = [])
  {
    
    $debug = false;

    $url = sprintf("%s%s", $this->_base_url, $path);

    if($payload)
    {
      $url = sprintf("%s?%s", $url, http_build_query($payload));
    }

    if($debug){
      print("$url\n");
    }

    if($debug){
      print(json_encode($header) . PHP_EOL);
    }

    $dtm = new \DateTime('now');
    $timestamp = $dtm->getTimestamp();
    $timestamp = $timestamp * 1000;

    $method = 'GET';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if($debug){
      curl_setopt($ch, CURLOPT_HEADER, true);
    }
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);

    if($debug){
      print("$response\n");
    }

    if($debug){
      $information = curl_getinfo($ch);
      $information = json_encode($information, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
      print("$information\n");
    }

    curl_close($ch);

    return $response;
  }
   
  function post($path, $payload = [], $custom_request = null)
  {

    $debug = true;

    $url = sprintf("%s%s", $this->_base_url, $path);

    if($debug){
      print("$url\n");
    }

    $dtm = new \DateTime('now');
    $timestamp = $dtm->getTimestamp();
    $timestamp = $timestamp * 1000;

    $method = 'POST';

    if($debug){
      print(json_encode($custom_request) . PHP_EOL);
    }

    if($custom_request)
    {
      $method = $custom_request;
    }

    $items = [$timestamp, $method, $path];

    if($payload)
    {
      $payload = json_encode($payload, JSON_UNESCAPED_SLASHES);
      $items = [$timestamp, $method, $path, $payload];
    }

    $data = implode('', $items);

    if($debug){
      print("$data\n");
    }

    $signature = hash_hmac('sha256', $data, $this->_api_secret);

    if($debug){
      print("$signature\n");
    }

    $header = ['Content-Type: application/json; charset=utf-8', 'X-Gw-Api-Key: ' . $this->_api_key, 'X-Gw-Timestamp: ' . $timestamp, 'X-Gw-Signature: ' . $signature];

    $fields = $payload;

    if($debug){
      print(json_encode($fields) . PHP_EOL);
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);

    if($custom_request)
    {
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $custom_request);
    }

    $response = curl_exec($ch);

    if($debug){
      print("$response\n");
    }

    $information = curl_getinfo($ch);
    $information = json_encode($information, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    if($debug){
      print("$information\n");
    }

    curl_close($ch);

    return $response;
  }

  function patch($path, $payload = [])
  {
    return $this->post($path, $payload, 'PATCH');
  }

  function put($path, $payload = [])
  {
    return $this->post($path, $payload, 'PUT');
  }

  function delete($path, $payload = [])
  {
    return $this->post($path, $payload, 'DELETE');
  }
}



