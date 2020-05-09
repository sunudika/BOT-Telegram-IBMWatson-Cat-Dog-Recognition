<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/BOT-Telegram-IBMWatson-Cat-Dog-Recognition/functions/Image.php';

$dataDB     = ImageTele\getImageData($url);

if (!(array) $dataDB):
    $classification = classifyImage($url);
    $dataImage = ImageTele\dataDefault($classification->animal, $classification->score,$url);
    ImageTele\insertNewRow($dataImage);
endif;