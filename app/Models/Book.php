<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title'
    ];

    /**
     * Get all of the indices for the Book
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function indices(): HasMany
    {
        return $this->hasMany(Index::class, 'book_id', 'id');
    }
}
