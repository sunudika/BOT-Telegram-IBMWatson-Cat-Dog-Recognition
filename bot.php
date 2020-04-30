<?php

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bot-telegram-counter/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/bot-telegram-counter/database/config.php';

date_default_timezone_set('Asia/Jakarta');

$configs = [
    "telegram" => [
        "token" => file_get_contents("private/TOKEN.txt")
    ]
];




DriverManager::loadDriver(TelegramDriver::class);

$botman = BotManFactory::create($configs);

$botman->group(['recipient' => '-1001307666764'], function(Botman $bot) { //'-1001184380882' grup api

    $bot->hears("/start@BitValueBot", function (BotMan $bot) {
        $user = $bot->getUser();
        $firstname = $user->getFirstName();
        $bot->reply("Willkommen $firstname 😊");
    });

    $bot->hears("{chat}", function (BotMan $bot){
        include "functions/request.php"; 
    });

    $bot->hears("/cek_data@BitValueBot", function (BotMan $bot){
        require_once $_SERVER['DOCUMENT_ROOT'] . '/bot-telegram-counter/functions/getter.php';
        $message = getMessage();
        $bot->reply($message);
    });

    $bot->hears("/kenal {nama}, {npm}", function (BotMan $bot, $nama, $npm) {
        $bot->reply("Halo! $nama, $npm");
    });

    $bot->hears("/help@BitValueBot", function (BotMan $bot) {
        $bot->reply("bot ini mencatat frekuensi chat setiap user yang menggunakan command" . PHP_EOL . "/start@BitValueBot - untuk mendapat sapaan" . PHP_EOL . 
        "/cek_data@BitValueBot - untuk melihat frekuensi chat semua user" . PHP_EOL . "/help@BitValueBot - untuk mendapatkan bantuan");
    });
});

$botman->hears("/start", function (BotMan $bot) {
    $user = $bot->getUser();
    $firstname = $user->getFirstName();
    $id_user = $user->getId();
    $bot->reply("Willkommen $firstname ($id_user) 😊");
});

$botman->hears("/kenal {nama}, {npm}", function (BotMan $bot, $nama, $npm) {
    $bot->reply("Halo! $nama, $npm");
});

$botman->hears("{chat}", function (BotMan $bot){
    include "functions/request.php"; 
    // $message = "IDmu: " . $dataUser->id_user . PHP_EOL;
    // $message .= "Usernamemu: " . $dataUser->username . PHP_EOL;
    // $message .= "Namamu: " . $dataUser->name . PHP_EOL;
    // $message .= "Frekuensimu: " . $dataUser->frequency . PHP_EOL;
    // $bot->reply($message);
});

$botman->hears("/cek_data", function (BotMan $bot){
    require_once $_SERVER['DOCUMENT_ROOT'] . '/bot-telegram-counter/functions/getter.php';
    $message = getMessage();
    $bot->reply($message);
});

$botman->hears("/help", function (BotMan $bot) {
        $bot->reply("bot ini mencatat frekuensi chat setiap user yang menggunakan command" . PHP_EOL . "/start - untuk mendapat sapaan" . PHP_EOL . 
        "/cek_data - untuk melihat frekuensi chat semua user" . PHP_EOL . "/help - untuk mendapatkan bantuan");
    });

$botman->listen();