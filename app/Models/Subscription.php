<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $fillable = [
        'name',
        'price',
        'type',
        'duration_in_days',
        // 'started_on',
        // 'ended_on',
        'max_products',
    ];

    public function tenants() {
        return $this->hasMany(Tenant::class);
    }
}
