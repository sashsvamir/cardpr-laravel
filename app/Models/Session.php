<?php
namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Session extends Model
{
    public $incrementing = false;

    // protected $appends = ['expires_at'];
    //
    // public function getExpiresAtAttribute()
    // {
    //     return Carbon::createFromTimestamp($this->last_activity)
    //         ->addMinutes(config('session.lifetime'))
    //         ->toDateTimeString();
    // }

    public function scopeActive(Builder $query)
    {
        return $query->where('last_activity', '>', Carbon::now()->subMinutes(config('session.lifetime'))->getTimestamp());
    }
}
