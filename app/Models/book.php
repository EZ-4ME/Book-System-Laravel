<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class book extends Model
{
    use HasFactory;
    protected $table = 'books';
    protected $fillable = [
        'user_id',
        'title',
        'description',
    ];

    public function rating()
    {
        return $this->hasMany('App\rating');
    }

}
