<?php

$data = json_decode(file_get_contents('php://input'), TRUE);
//пишем в файл лог сообщений
file_put_contents('file.txt', '$data: '.print_r($data, 1)."\n", FILE_APPEND);

$data = $data['callback_query'] ? $data['callback_query'] : $data['message'];

define('TOKEN', 'secrets.TELEGRAM_BOT_TOKEN');

$message = mb_strtolower(($data['text'] ? $data['text'] : $data['data']),'utf-8');


switch ($message) {
    case 'да':
        $method = 'sendMessage';
		$send_data = [
			'text' => 'Что вы хотите заказать?',
			'reply_markup'  => [
				'resize_keyboard' => true,
				'keyboard' => [
						[
							['text' => 'Яблоки'],
							['text' => 'Груши'],
						],
						[
							['text' => 'Лук'],
							['text' => 'Чеснок'],
						]
					]
				]
			];
    break;
	case 'нет':
        $method = 'sendMessage';
		$send_data = ['text' => 'Приходите еще'];
    break;
	case 'яблоки':
        $method = 'sendMessage';
		$send_data = ['text' => 'заказ принят!'];
    break;
	case 'груши':
        $method = 'sendMessage';
		$send_data = ['text' => 'заказ принят!'];
    break;
	case 'лук':
        $method = 'sendMessage';
		$send_data = ['text' => 'заказ принят!'];
    break;
	case 'чеснок':
        $method = 'sendMessage';
		$send_data = ['text' => 'заказ принят!'];
    break;
	default:
		$method = 'sendMessage';
		$send_data = [
			'text' => 'Вы хотите сделать заказ?',
			'reply_markup'  => [
				'resize_keyboard' => true,
				'keyboard' => [
						[
							['text' => 'Да'],
							['text' => 'Нет'],
						]
					]
				]
			];
}



$send_data['chat_id'] = $data['chat'] ['id'];
$send_data['text'] = date("h:i:s");
getNumberfact();
if(date("i:s").Equals("00:00")){
  $res = sendTelegram('sendMessage', $send_data );
}




function sendTelegram($method, $data, $headers = [])
{
	$curl = curl_init();
	curl_setopt_array($curl, [
		CURLOPT_POST => 1,
		CURLOPT_HEADER => 0,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => 'https://api.telegram.org/bot' . TOKEN . '/' . $method,
		CURLOPT_POSTFIELDS => json_encode($data),
		CURLOPT_HTTPHEADER => array_merge(array("Content-Type: application/json"))
	]);
	$result = curl_exec($curl);
	curl_close($curl);
	return (json_decode($result, 1) ? json_decode($result, 1) : $result);
}
function getNumberfact()
{
	$curl = curl_init();
	curl_setopt_array($curl, [
		CURLOPT_POST => 1,
		CURLOPT_HEADER => 0,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => 'http://numbersapi.com/23' . 42 . '?json',
		CURLOPT_HTTPHEADER => array_merge(array("Content-Type: application/json"))
	]);
	$result = curl_exec($curl);
	curl_close($curl);
  $send_data['text'] = $result['text'];
  sendTelegram('sendMessage', $send_data );
	return (json_decode($result, 1) ? json_decode($result, 1) : $result);
}

?>
