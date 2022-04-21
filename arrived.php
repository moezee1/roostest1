<?php

$dt= json_decode(file_get_contents("php://input"),true);
$email = $dt['data']['node']['client']['email'];
$start = $dt['data']['node']['startAt'];
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://rest.gohighlevel.com/v1/contacts/lookup?email=$email",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJsb2NhdGlvbl9pZCI6IjVQekVPc09lbk1wSzlNeXhrQW96IiwiY29tcGFueV9pZCI6InZUUDlmakFwRk9wbElRazZVOXR2IiwidmVyc2lvbiI6MSwiaWF0IjoxNjQ1NTA5ODcwMzc0LCJzdWIiOiJGa1Bnb0JxMTdJVThxWm9HYmNDbSJ9.MpCZBnnY5EQp04MbN0CcslySKSXeRO6TLwsGeDv9mAM',
    "Accept: application/json"
  ),
));

$response = curl_exec($curl);
curl_close($curl);
//print_r(json_decode($response,true)["contacts"][0]["id"]);
$cid=json_decode($response,true)["contacts"][0]["id"];

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://rest.gohighlevel.com/v1/contacts/$cid/appointments/",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJsb2NhdGlvbl9pZCI6IjVQekVPc09lbk1wSzlNeXhrQW96IiwiY29tcGFueV9pZCI6InZUUDlmakFwRk9wbElRazZVOXR2IiwidmVyc2lvbiI6MSwiaWF0IjoxNjQ1NTA5ODcwMzc0LCJzdWIiOiJGa1Bnb0JxMTdJVThxWm9HYmNDbSJ9.MpCZBnnY5EQp04MbN0CcslySKSXeRO6TLwsGeDv9mAM'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
date_default_timezone_set("America/New_York");

for($x=0;$x<sizeof(json_decode($response,true)["events"]);$x++){
    if(strtotime(json_decode($response,true)["events"][$x]["startTime"]) == strtotime($start) ){
      $id=json_decode($response,true)["events"][$x]["id"];
    $curl1 = curl_init();

curl_setopt_array($curl1, array(
  CURLOPT_URL => "https://rest.gohighlevel.com/v1/appointments/$id/status",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'PUT',
  CURLOPT_POSTFIELDS =>"status=showed",
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJsb2NhdGlvbl9pZCI6IjVQekVPc09lbk1wSzlNeXhrQW96IiwiY29tcGFueV9pZCI6InZUUDlmakFwRk9wbElRazZVOXR2IiwidmVyc2lvbiI6MSwiaWF0IjoxNjQ1NTA5ODcwMzc0LCJzdWIiOiJGa1Bnb0JxMTdJVThxWm9HYmNDbSJ9.MpCZBnnY5EQp04MbN0CcslySKSXeRO6TLwsGeDv9mAM'
  ),
));

$response1 = curl_exec($curl1);

curl_close($curl1);
echo $response1;
    
    
    }
}
//print_r(json_decode($response,true)["events"][0]["startTime"]);
//print_r(strtotime(json_decode($response,true)["events"][0]["startTime"]));