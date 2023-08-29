<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Index extends Model
{
    use HasFactory;
    protected $fillable = [
        'book_id',
        'parent_index_id',
        'title',
        'page'
    ];
}
