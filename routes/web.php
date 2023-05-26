<?php

use Illuminate\Support\Facades\Route;
use YooKassa\Client;

Route::get('/create_payment', function () {
    $client = new Client();
    $client -> setAuth($_GET['login'], $_GET['password']);
    $payment = $client -> createPayment(
        array(
            'amount' => array(
                'value' => $_GET['count'],
                'currency' => 'RUB',
            ),
            'confirmation' => array(
                'type' => 'redirect',
                'return_url' => $_GET['callback'],
            ),
            'capture' => true,
            'description' => 'Оплата из бота',
        )
    );
    return $payment['confirmation']['confirmation_url'];
});

Route::get("/get_status/{order_id}", function ($order_id) {
    $client = new Client();
    $client -> setAuth($_GET['login'], $_GET['password']);
    return $client-> getPaymentInfo($order_id)['status'];
});
