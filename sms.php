<?php

$auth = "scretkodenya";

$smsmsg = "akun Anda di Intech Panel telah aktif. 30 hari saldo tetap 0 otomatis akan terhapus, terimakasih.";
$sms[0]['phone_number'] = "$nohp";
$sms[0]['message'] = "Halo $nama, $smsmsg";
$sms[0]['device_id'] = 93715;

$post = json_encode($sms);

$ch = curl_init("https://smsgateway.me/api/v4/message/send");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: $auth"));
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
$out = curl_exec($ch);

?>
