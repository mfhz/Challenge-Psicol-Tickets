<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'available_tickets',
        'date'
    ];

    protected $appends = ['available', 'sell', 'sell_chairs', 'available_chairs'];


    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'event_id', 'id');
    }

    public function getAvailableAttribute()
    {
        return $this->available_tickets - $this->tickets->count();
    }

    public function getSellAttribute()
    {
        return $this->tickets->count();
    }

    public function getSellChairsAttribute()
    {
       return $this->tickets->pluck('chair')->toArray();
    }

    public function getAvailableChairsAttribute()
    {
       return array_values(array_diff(range(1, $this->available_tickets), $this->sell_chairs));
    }
}
