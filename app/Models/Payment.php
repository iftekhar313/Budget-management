<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
     use HasFactory;

    protected $fillable = ['participant_id', 'amount', 'paid_at'];

    public function participant() {
        return $this->belongsTo(Participant::class);
    }
}
