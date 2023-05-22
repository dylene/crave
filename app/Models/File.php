<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $connection = 'tenant';

    protected $fillable = [
        'filename',
        'filename',
        'filetype',
        'filepath',
        'product_id',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
