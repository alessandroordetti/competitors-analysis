<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BestCompetitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'product_title',
        'sale_price',
        'winner_competitor',
    ];
}
