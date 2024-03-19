<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rating extends Model
{
    use HasFactory;
    protected $table = 'rating';
    protected $fillable = [
        'user_id',
        'book_id',
        'rating',
    ];

    public function book()
    {
        return $this->belongsTo('App\book');
    }
}
