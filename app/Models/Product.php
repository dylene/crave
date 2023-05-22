<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $connection = 'tenant';


    protected $fillable = [
        'name',
        'price',
        'quantity',
        'file'
    ];


        public function files() {
        return $this->hasMany(File::class);
    }
}
