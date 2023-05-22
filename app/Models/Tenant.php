<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'company',
            'email',
            'subscription_id',
            'payment_status',
            'payment_gateway_id'
        ];
    }


    public function subscription() {
        return $this->belongsTo(Subscription::class);
    }

    public function paymentGateway() {
        return $this->belongsTo(PaymentGateway::class);
    }

    // public function users() {
    //     return $this->hasMany(User::class);
    // }
    
}