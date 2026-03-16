<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',
        'amount'
    ];

    public function transactions()
    {
        return $this->belongsToMany(
            Transaction::class,
            'transaction_products'
        )->withPivot(['quantity', 'amount']);
    }
}
