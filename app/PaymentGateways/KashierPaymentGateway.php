<?php

namespace App\PaymentGateways;

use App\Contracts\Repositories\PaymentGateway;
use App\Enums\Currency;
use App\Enums\OrderStatus;
use Asciisd\Kashier\KashierService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KashierPaymentGateway implements PaymentGateway
{
    const string PROVIDER_KASHIER = 'Kashier';

    public KashierService $kashier;

    public string $id;

    public function __construct(public int $amount)
    {
        $this->kashier = new KashierService;
        $this->id = uniqid('kashier_');
    }

    public static function pay($amount): PaymentGateway
    {
        return new self($amount);
    }

    public function calculateTotalAmount($rate = null, $fees = null): string
    {
        $total_to_charge = $this->rawAmount();

        if (! empty($fees) || ($this->vendorFees() && $this->vendorFees() != 0)) {
            $final_fees = $fees ?: $this->vendorFees();
            $total_to_charge = $total_to_charge - ($total_to_charge * $final_fees / 100);
        }

        return number_format($this->ceiling($total_to_charge, -0.01), 2, '.', '');
    }

    public function vendorFees(): float
    {
        return 2.5;
    }

    public function currency(): string
    {
        return Currency::EGP->value;
    }

    public function provider(): string
    {
        return self::PROVIDER_KASHIER;
    }

    public function conversionRate(): float
    {
        return 1.0;
    }

    public function id(): string
    {
        return $this->id;
    }

    public static function receipt($transaction_id): string
    {
        return url('/tap/receipt?tap_id='.$transaction_id);
    }

    public function paymentMethodIcon(): string
    {
        $method = Str::lower(Str::kebab($this->paymentMethod()));

        return Storage::disk('s3')->url("invoices/img/card/{$method}-dark@2x.png");
    }

    public function paymentMethodSvg(): string
    {
        $method = Str::lower(Str::kebab($this->paymentMethod()));

        return Storage::disk('s3')->url("invoices/img/card/svg/{$method}.svg");
    }

    public function statusIcon(): string
    {
        $status = Str::lower($this->charge->status);

        return Storage::disk('s3')->url("invoices/img/status/{$status}.png");
    }

    public function ceiling($number, float $significance = 1.0): float
    {
        return is_numeric($number) && is_numeric($significance)
            ? ceil($number / $significance) * $significance
            : false;
    }

    public function rawAmount(): int
    {
        return $this->amount;
    }

    public function status(): string
    {
        return OrderStatus::Initiated->value;
    }

    public function paymentMethod(): string
    {
        return 'CARD';
    }

    public function owner(): \Illuminate\Contracts\Auth\Authenticatable
    {
        return auth()->user();
    }

    public function actionUrl(): string
    {
        return $this->kashier->buildPaymentUrl($this->amount, $this->id, [
            'brandColor' => '#014254',
        ]);
    }
}
