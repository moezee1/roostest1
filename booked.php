<?php

$dt= json_decode(file_get_contents("php://input"),true);

$curl = curl_init();

$email = $dt['data']['node']['client']['email'];
$phone= $dt['data']['node']['client']['mobilePhone'];
$tz=$dt['data']['node']['location']['tz'];
$fname= $dt['data']['node']['client']['firstName'];
$lname= $dt['data']['node']['client']['lastName'];  



/*
$email = "test@appt.com";
$phone= "+16135818360";
$start="2022-04-12T09:00:00-07:00";
$tz= "America/Los_Angeles";
$name= "test appt";
*/
for($x=0;$x<sizeof($dt['data']['node']['appointmentServices']);$x++){
$stname=$dt['data']['node']['appointmentServices'][$x]['staff']['firstName'].' '.$dt['data']['node']['appointmentServices'][$x]['staff']['lastName'];
$sername=$dt['data']['node']['appointmentServices'][$x]['service']['name'];
$aid=$dt['data']['node']['appointmentServices'][$x]['id'];
$start=$dt['data']['node']['appointmentServices'][$x]['startAt'];
$entries ="calendarId=pGl271ri8NdHMET4VBqE&selectedTimezone=$tz&selectedSlot=$start&email=$email&firstName=$fname&lastName=$lname&calendarNotes=$aid&2u5QMfq5DkdLHUUbB1JD=$stname&tViGDbvTcV9IVZBGdaQJ=$sername";



curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://rest.gohighlevel.com/v1/appointments/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$entries,
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJsb2NhdGlvbl9pZCI6IjVQekVPc09lbk1wSzlNeXhrQW96IiwiY29tcGFueV9pZCI6InZUUDlmakFwRk9wbElRazZVOXR2IiwidmVyc2lvbiI6MSwiaWF0IjoxNjQ1NTA5ODcwMzc0LCJzdWIiOiJGa1Bnb0JxMTdJVThxWm9HYmNDbSJ9.MpCZBnnY5EQp04MbN0CcslySKSXeRO6TLwsGeDv9mAM'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

$cid=json_decode($response,true)["contact"]["id"];

$curl2 = curl_init();

curl_setopt_array($curl2, array(
  CURLOPT_URL => "https://rest.gohighlevel.com/v1/contacts/$cid/workflow/c2e8bf61-8c56-47d2-939a-b683590c5082",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_POSTFIELDS =>"eventStartTime=$start",
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJsb2NhdGlvbl9pZCI6IjVQekVPc09lbk1wSzlNeXhrQW96IiwiY29tcGFueV9pZCI6InZUUDlmakFwRk9wbElRazZVOXR2IiwidmVyc2lvbiI6MSwiaWF0IjoxNjQ1NTA5ODcwMzc0LCJzdWIiOiJGa1Bnb0JxMTdJVThxWm9HYmNDbSJ9.MpCZBnnY5EQp04MbN0CcslySKSXeRO6TLwsGeDv9mAM'
  ),
));

$response2 = curl_exec($curl2);

curl_close($curl2);
echo $response2;   
sleep(10);

}
?>