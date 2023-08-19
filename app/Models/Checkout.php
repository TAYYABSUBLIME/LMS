<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', // Add 'user_id' to the fillable fields
        'book_id',
        'checkout_date',
        'return_date',
    ];
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
