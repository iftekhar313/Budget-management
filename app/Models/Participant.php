<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Participant extends Model
{
     use HasFactory;

    protected $fillable = ['event_id', 'name', 'expected_contribution'];

    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public function getTotalPaidAttribute() {
        return $this->payments->sum('amount');
    }
}
