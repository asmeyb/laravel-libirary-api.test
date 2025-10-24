<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    protected $fillable = [
        'title', 'isbn', 'description', 'author_id', 'gener', 'published_date',
        'total_copies', 'available_copies', 'price', 'cover_image', 'status'
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    public function isAvailable()
    {
        return $this->available_copies > 0;
    }
    public function borrow()
    {
        if($this->available_copies > 0)
        {
            $this->decrement('available_copies');
        }
    }

    public function returnBook()
    {
        if($this->available_copies < $this->total_copies)
        {
            $this->increment('avaiable_copies');
        }
    }
}
