<?php

namespace App\Models;

use GuzzleHttp\Psr7\Query;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
class Book extends Model
{
        protected $fillable = ['title', 'author', 'created_at', 'updated_at'];

        public function reviews()
        {
            return $this->hasMany(Review::class);
        }
        use HasFactory;

        // public function scopeTitle(Builder $query,  $title)
        // {
        //     return $query->where('title', 'LIKE', '%' . $title . '%');
        // }

        public function scopeTitle(Builder $query, string $title): Builder
        {
            return $query->where('title', 'LIKE', '%' . $title . '%');
        }

        // public function scopeDateRange(Builder $query, string $startDate, string $endDate): Builder|QueryBuilder{
        //     return $query->whereBetween('created_at',[
        //         $startDate,
        //         $endDate
        //     ]);
        // }
        // public function scopeAvgRating(Builder $query): Builder
        // {
        //     return $query->withAvg('rating', 'reviews');
        // }
      



        public function scopePopular(Builder $query, $from = null, $to = null): Builder|QueryBuilder {
            return $query->withCount(['reviews'=>fn(Builder $q)=>$this->DateRangeFilter($q, $from, $to)])
->orderBy('reviews_count', 'desc');
        }

      public function scopeHighestRated(Builder $query,  $from = null, $to = null): Builder|QueryBuilder {
    return $query->withAvg(['reviews'=>fn(Builder $q)=>$this->DateRangeFilter($q, $from, $to)], 'rating')->orderByDesc('reviews_avg_rating');
}
public function scopeMinReviews(Builder $query, int $min): Builder
{
    return $query->having('reviews_count', '>=', $min);
}

        private function DateRangeFilter(Builder $query, $from = null, $to = null){
            if ($from && $to) {
                return $query->whereBetween('created_at', [$from, $to]);
            } elseif ($from) {
                return $query->where('created_at', '>=', $from);
            } elseif ($to) {
                return $query->where('created_at', '<=', $to);
            }
        }


        public function scopePopularLastMonth(Builder $query): Builder|QueryBuilder {
          
            return $query->popular(now()->subMonth(), now())->highestRated(now()->subMonth(), now())->minReviews(2);

        }
  public function scopePopularLast6Months(Builder $query): Builder|QueryBuilder {
          
            return $query->popular(now()->subMonth(6), now())->highestRated(now()->subMonth(6), now())->minReviews(5);

        }


         public function scopeHighestRatedLastMonth(Builder $query): Builder|QueryBuilder {
          
          return $query->highestRated(now()->subMonth(), now())->popular(now()->subMonth(), now())->minReviews(2);

        }


   public function scopeHighestRated6LastMonth(Builder $query): Builder|QueryBuilder {
          
          return $query->highestRated(now()->subMonth(6), now())->popular(now()->subMonth(6), now())->minReviews(5);

        }

}
