<?php

namespace ChatTele;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bot-telegram-counter/database/config.php';

date_default_timezone_set('Asia/Jakarta');

function getUserTodayData($id_user)
{
    global $connection;

    $querySelectData    = "SELECT * FROM chat WHERE DATE(created_at) = CURDATE() AND id_user = $id_user LIMIT 1";
    $resultQuery        = mysqli_query($connection, $querySelectData);

    return (object) mysqli_fetch_assoc($resultQuery);
}

function dataDefault($user) {
    $data   = [
        "id_user"   => $user->getId(),
        "username"  => $user->getUsername(),
        "name"      => $user->getFirstName(),
        "frequency" =>  "1"
    ];

    return (object) $data;
}

function getLastData()
{
    global $connection;

    $querySelectLastData    = "SELECT * FROM chat WHERE DATE(created_at) = CURDATE()
                                ORDER BY updated_at DESC
                                LIMIT 1";
    $resultQuery        = mysqli_query($connection, $querySelectLastData);

    return (object) mysqli_fetch_assoc($resultQuery);
}

function insertNewRow($dataUser)
{
    global $connection;

    $queryInsertUser    = "INSERT INTO chat (id_user, username, name, frequency)
                            VALUES ($dataUser->id_user, '$dataUser->username', '$dataUser->name', $dataUser->frequency)";

    mysqli_query($connection, $queryInsertUser);
}

function isDBExpired($dataDB, $dataUser)
{
    $current_time = time();
    $convert_current_time = date('Y:m:d H:i:s', $current_time);

    if (
        $dataDB->frequency < $dataUser->frequency ||
        $dataDB->updated_at < $convert_current_time
    ) {

        return true;
    }

    return false;
}

function updateTodayData($id, $frequency, $dataUser) {
    global $connection;


    $dataUser->frequency = $frequency + 1;

    $queryUpdateData    = "UPDATE chat
                            SET frequency   = $dataUser->frequency,
                                updated_at  = CURRENT_TIMESTAMP()
                            WHERE id = $id";

    mysqli_query($connection, $queryUpdateData);
}