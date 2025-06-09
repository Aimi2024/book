<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['review', 'rating', 'book_id', 'created_at', 'updated_at'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    use HasFactory;

    protected static function booted()
    {
        static::updated(function (Review $review){
            cache()->forget('book:' . md5($review->book_id));
        });
         static::deleted(function (Review $review){
            cache()->forget('book:' . md5($review->book_id));
        });
    }
}
