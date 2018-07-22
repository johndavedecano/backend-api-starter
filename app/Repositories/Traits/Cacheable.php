<?php namespace App\Repositories\Traits;

use Illuminate\Support\Facades\Cache;

/**
 * Cachaeable - Allows caching of query results.
 */
trait Cacheable
{
    /**
     * Cache given query
     *
     * @param string $key
     * @param Illuminate\Database\Eloquent\Collection|Illuminate\Database\Eloquent\Model $query
     * @param integer $time
     * @return Illuminate\Database\Eloquent\Collection|Illuminate\Database\Eloquent\Model
     */
    public function cache($key, $query, $time = 60)
    {
        return Cache::remember($key, $time, function () use ($query) {
            return $query;
        });
    }
}
