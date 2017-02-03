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
		ob_start();
		var_dump($event);
		$txt = ob_get_clean();
		$reply = $txt;
		$messages = [
		'type' => 'text',
		'text' => $reply
		];	
		if ($event['type'] == 'message') {
			// Get replyToken
			$replyToken = $event['replyToken'];	
			
			if($event['message']['type'] == 'text')
			{
				// Get text sent
				$text = $event['message']['text'];
				
				// Build message to reply back
				if (strtolower($text) == 'cpu') {
					$reply = 'cpu\'s status';
					$messages = [					
					'type' => 'image',
					'originalContentUrl' => 'https://basis-line-bot.herokuapp.com/images/CPU.png',
					'previewImageUrl'=> 'https://basis-line-bot.herokuapp.com/images/CPU.png'
					];
				}
				else if (strtolower($text) == 'user') {
					$reply = 'cpu\'s status';
					$messages = [					
					'type' => 'image',
					'originalContentUrl' => 'https://basis-line-bot.herokuapp.com/images/USR.png',
					'previewImageUrl'=> 'https://basis-line-bot.herokuapp.com/images/USR.png'
					];
				}
				else if (strtolower($text) == 'work process') {
					$reply = 'cpu\'s status';
					$messages = [					
					'type' => 'image',
					'originalContentUrl' => 'https://basis-line-bot.herokuapp.com/images/WP.png',
					'previewImageUrl'=> 'https://basis-line-bot.herokuapp.com/images/WP.png'
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
					ob_start();
					var_dump($event);
					$txt = ob_get_clean();
					$reply = $txt;
					$messages = [
					'type' => 'text',
					'text' => $reply
					];
				}
			}
			else if($event['message']['type'] == 'sticker')
			{
					ob_start();
					var_dump($event);
					$txt = ob_get_clean();
					$reply = $txt;
					$messages = [
					'type' => 'text',
					'text' => $reply
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
echo "No error";
