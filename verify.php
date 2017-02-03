<?php
$access_token = 'P3avdIxyxnYbA4xJmyGCWyD2zg5Yi785QZIKdXNajsJV/t8zQKRqfLus2MmwarjTq8jUlLtx1p/YhF+R7tRCv0aQOia3KQhIkPR2PL45xst9NCURrzMXPoVqI0oVFZ1To6tHwSwCeJg0QuXo7HyYuAdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;