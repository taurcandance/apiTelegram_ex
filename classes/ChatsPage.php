<?php

class ChatsPage extends Page
{
    private $url;
    private $chatId;

    public function __construct($chatId)
    {
        parent::__construct();
        $token        = '<token>';
        $this->url    = "https://api.telegram.org/bot$token/";
        $this->chatId = $chatId;
    }

    public function run(string $apiMethodName = null, array $methodArgs = null)
    {
        $dataArray = array();
        foreach ($methodArgs as $arg) {
            if ($arg == "") {
                continue;
            }
            $parts                = explode('=', $arg);
            $dataArray[$parts[0]] = $parts[1];
        }
        $request = $this->url.$apiMethodName.'?'.http_build_query($dataArray);

        $response = @file_get_contents("$request");

        if (false == $response) {
            $error = [' Server not available or something in Request incorrect <br />'];
            $this->render($error, $apiMethodName);

            return;
        }
        $responseData = json_decode($response, true);
        $chatMessages = $this->getChatMessages($responseData['result']);
        $this->render($chatMessages, $apiMethodName);
    }

    public function getChatMessages(array $allMessages)
    {

        return array_filter(
            $allMessages,
            function ($var) {
                if ($var['message']['chat']['id'] == $this->chatId) {
                    $var['message']['date'] = $this->refDate($var['message']['date']);

                    return true;
                }

                return false;

            }
        );
    }

    private function refDate(int $unixDate): string
    {
        date_default_timezone_set('Europe/Minsk');
        $date = date("Y-m-d H:i:s", $unixDate);

        return $date;
    }
}