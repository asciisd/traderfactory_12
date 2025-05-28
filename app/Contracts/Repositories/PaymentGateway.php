<?php

namespace App\Contracts\Repositories;

interface PaymentGateway
{
    public function rawAmount();

    public function status();

    public function paymentMethod();

    public function calculateTotalAmount();

    public function currency();

    public function provider();

    public function conversionRate();

    public function vendorFees();

    public static function pay($amount): self;

    public function owner();

    public function id();

    public function actionUrl();

    public function paymentMethodIcon();

    public function paymentMethodSvg();

    public function statusIcon();
}
