<?php
$ch = curl_init();
$app_ID = "APP_ID_1123453311";
$secretKey = "0662abb5-13c7-38ab-cd12-236e58f43766";
curl_setopt($ch, CURLOPT_URL, 'https://restpilot.paylink.sa/api/auth');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"apiId": "'.$app_ID.'","secretKey":"'.$secretKey.'"}');
$headers = array();
$headers[] = 'Accept: */*';
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$token = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$my_token = json_decode($token, true);
print_r($my_token);
if(!isset($my_token['id_token'])){
  exit();
}

$price = 5;
$qty = 1;
$title = 'test';
$callBackUrl = "https://restpilot.paylink.sa";
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://restpilot.paylink.sa/api/addInvoice');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"products": [{"description":"Donation","imageSrc":"","isDigital": true,"price": '.$price.',"qty": '.$qty.',"title": "'.$title.'"}],"amount": '.$price.',"callBackUrl": "'.$callBackUrl.'","clientMobile":"0509200900","clientEmail":"myclient@email.com","clientName":"Zaid Matooq","note": "This invoice is for VIP client.","orderNumber": "ORD-123123123"}');

$headers = array();
$headers[] = 'Accept: application/json;charset=UTF-8';
$headers[] = 'Authorization: Bearer '.$my_token['id_token'];
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
print_r($result);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$res = json_decode($result, true);
if(isset($res['url'])){
  header('Location: '.$res['url']);
}

die;