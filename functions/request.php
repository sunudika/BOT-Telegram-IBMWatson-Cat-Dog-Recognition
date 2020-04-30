<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bot-telegram-counter/functions/Chat.php';
    
$user = $bot->getUser();
$id_user = $user->getId();
$dataDB     = ChatTele\getUserTodayData($id_user);

$dataUser = ChatTele\dataDefault($user);

if (!(array) $dataDB):
    ChatTele\insertNewRow($dataUser);
elseif (ChatTele\isDBExpired($dataDB, $dataUser)):
    ChatTele\updateTodayData($dataDB->id, $dataDB->frequency, $dataUser);
endif;