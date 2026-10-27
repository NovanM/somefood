<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'unit',
        'stock_quantity',
        'min_stock_alert',
        'unit_cost',
        'supplier',
    ];

    protected $casts = [
        'stock_quantity' => 'decimal:2',
        'min_stock_alert' => 'decimal:2',
        'unit_cost' => 'decimal:2',
    ];

    public function isLowStock(): bool
    {
        return $this->stock_quantity <= $this->min_stock_alert;
    }
}
