<?php

  include_once(__DIR__ . '/Resources/Link/LinkInterface.php');
  include_once(__DIR__ . '/Resources/Reporting/ReportingInterface.php');
  include_once(__DIR__ . '/Resources/Transaction/TransactionInterface.php');
  include_once(__DIR__ . '/Resources/Account/AccountInterface.php');
  include_once(__DIR__ . '/Resources/Terminal/TerminalInterface.php');
  include_once(__DIR__ . '/RestClient.php');
  include_once(__DIR__ . '/Client.php');
  include_once(__DIR__ . '/Settings.php');

  $worldnet = new \Worldnet\Client(WORLDNET_API_KEY, WORLDNET_BASE_URL);

  /************************
  *  Account              *
  ************************/

  // $item = $worldnet->terminal->list();
  // foreach($item->data as $item){
  //   $json = json_encode($item, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
  //   print("$json\n");
  // }

  // $terminal = "4159001";
  // $item = $worldnet->terminal->devices($terminal);
  // $json = json_encode($item, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
  // print("$json\n");

  // $url = "/merchant/api/v1/account/terminals/4159001/devices/BBPOS_CHP2X";
  // $item = $worldnet->link->follow($url);
  // $json = json_encode($item, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
  // print("$json\n");

  // $terminal = "4159001";
  // $item = $worldnet->transaction->search($terminal);
  // $json = json_encode($item, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
  // print("$json\n");

  // $url = "/merchant/api/v1/transaction/payments/E41OS37G0X";
  // $item = $worldnet->link->follow($url);
  // $json = json_encode($item, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
  // print("$json\n");

  // $terminal = "4159001";
  // $item = $worldnet->reporting->list($terminal);
  // $json = json_encode($item, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
  // print("$json\n");

  // $terminal = "4159001";
  // $uniqueRef = "BAHIMOA9NJ";
  // $item = $worldnet->reporting->get($terminal, $uniqueRef);
  // $json = json_encode($item, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
  // print("$json\n");

  // $url = "/merchant/api/v1/transaction/payments/CMNGW4V1W0";
  // $item = $worldnet->link->follow($url);
  // $json = json_encode($item, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
  // print("$json\n");

  $terminal = "4159001";
  $tz = new DateTimeZone('America/New_York');
  $dtm = new DateTime('now', $tz);
  $date = $dtm->format('Ymd');
  $order_id = sprintf("order-%s", $date);
  $totalAmount = 10.51;
  $order = ['order_id' => $order_id, 'totalAmount' => $totalAmount, 'currency' => 'USD'];
  $cardNumber = '5413330089604111';
  $cardDetails = ['dataFormat' => 'PLAIN_TEXT', 'cardNumber' => $cardNumber];
  $customerAccount = ['payloadType' => 'KEYED', 'cardDetails' => $cardDetails];
  $data = ['terminal' => $terminal, 'order' => $order, 'customerAccount' => $customerAccount];
  // $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
  // print("$json\n");
  // die;

  $item = $worldnet->transaction->create($data);
  $json = json_encode($item, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
  print("$json\n");

 