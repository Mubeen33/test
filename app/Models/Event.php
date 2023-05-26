<?php

namespace App\Models;
use App\Models\Workshop;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    public function getWorkShops() {
        return $this->hasMany(Workshop::class, 'event_id');
    }
}
