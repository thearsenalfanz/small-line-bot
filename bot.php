<?php
$access_token = 'P3avdIxyxnYbA4xJmyGCWyD2zg5Yi785QZIKdXNajsJV/t8zQKRqfLus2MmwarjTq8jUlLtx1p/YhF+R7tRCv0aQOia3KQhIkPR2PL45xst9NCURrzMXPoVqI0oVFZ1To6tHwSwCeJg0QuXo7HyYuAdB04t89/1O/w1cDnyilFU=';
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		if ($event['type'] == 'message') {
			// Get replyToken
			$replyToken = $event['replyToken'];	
			if($event['message']['type'] == 'text')
			{
				// Get text sent
				$text = $event['message']['text'];
				$path = 'https://mc.egat.co.th/line/images/';
				
				// Build message to reply back
				if (strtolower($text) == 'cpu') {
					$reply = 'cpu\'s status';
					$messages = [					
					'type' => 'image',
					'originalContentUrl' => $path.'CPU.png',
					'previewImageUrl'=> $path.'CPU.png'
					];
				}
				else if (strtolower($text) == 'user') {
					$reply = 'cpu\'s status';
					$messages = [					
					'type' => 'image',
					'originalContentUrl' => $path.'USR.png',
					'previewImageUrl'=> $path.'USR.png'
					];
				}
				else if (strtolower($text) == 'work process' || strtolower($text) == 'wp') {
					$reply = 'cpu\'s status';
					$messages = [					
					'type' => 'image',
					'originalContentUrl' => $path.'WP.png',
					'previewImageUrl'=> $path.'WP.png'
					];
				}
				else if (strtolower($text) == 'version')
				{
					$reply = 'version 0.6, 13 Nov 2016';
					$messages = [
					'type' => 'text',
					'text' => $reply
					];
				}
				else {
					$reply = 'พิมพ์ cpu เพื่อดูปริมาณการใช้งาน cpu
					พิมพ์ user เพื่อดูจำนวน user ที่ log on
					พิมพ์ work process หรือ wp เพื่อดูจำนวน work process';
					$messages = [
					'type' => 'text',
					'text' => $reply
					];
				}
			}
			else if($event['message']['type'] == 'sticker')
			{
				$packages = array('1','1','1','1','1','2','2','2','2','2','3','3','3','3');
				$stickers = array('13','106','125','137','138','159','167','171','172','525','180','182','184','200');
				$id = rand(1,14);

				$messages = [
				'type' => 'sticker',
				'packageId' => $packages[$id],
				'stickerId' => $stickers[$id]
				];			
			}
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);
			echo $result . "\r\n";
		}
	}
}
if (isset($_GET['push']) && $_GET['push'] == 1)
{
	$path = 'https://mc.egat.co.th/line/images/';
	$filename = array('CPU.png','USR.png','WP.png');

	for($i=0; $i<3; $i++)
	{
		$messages = [
		'type' => 'image',
		'originalContentUrl' => $path.$filename[$i],
		'previewImageUrl'=> $path.$filename[$i]
		];
		$url = 'https://api.line.me/v2/bot/message/push';
		$data = [
		'to' => 'Ue39b5f714f4424cb448ba4f6550bda5c',
		'messages' => [$messages],
		];
		$post = json_encode($data);
		$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		curl_close($ch);
		echo $result . "\r\n";
		}
}
echo "No error";
