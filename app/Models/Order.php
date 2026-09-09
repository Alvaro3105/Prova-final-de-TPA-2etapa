<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'cliente',
        'status',
        'codigo_pedido',
        'total',
    ];

    protected function casts(): array
    {
        return ['total' => 'integer'];
    }
}
