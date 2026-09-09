<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $table = "order";

    protected $fillable = [
        'Cliente',
        'Status',
        'codigo_pedido',
        'total',
    ];
}
