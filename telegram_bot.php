<?php
//
class BonusCard {
    public $card;
    public $date;
}

$soap_client = new SoapClient('https://ulydala.utari.kz/UDR/ws/DiscountService.1cws?wsdl', [
    # This array and its values are optional
    'soap_version' => SOAP_1_1,
    'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
    'cache_wsdl' => WSDL_CACHE_BOTH,
    # Helps with debugging
    'trace' => TRUE,
    'PROXY_PASSWORD' => Ud112233+,
    'proxy_login' => Web,
    'exceptions' => TRUE
]);
//
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



$send_data['chat_id'] = $client->ПолучитьОстатокБонусов("7710200100002372",date("23-04-2022 00:00:00"));
//$data['chat'] ['id'];

$res = sendTelegram($method, $send_data);




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

?>
