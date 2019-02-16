<?php

require_once __DIR__.'/vendor/autoload.php';

$chatMethods = ['getUpdates', 'sendMessage'];
$method = $_GET['method'];

if ( ! in_array($method, $chatMethods)) {
    $page = new StartingPage();
    $page->run();

    return;
}

$params = $_GET['advParams'];
$chat_id = "-332012687";
$page   = new ChatsPage($chat_id);
$page->run($method, $params);