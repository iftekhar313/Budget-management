<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'budget', 'destination', 'date'];

    protected $casts = [
        'date' => 'date',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function participants() {
        return $this->hasMany(Participant::class);
    }

    public function expenses() {
        return $this->hasMany(Expense::class);
    }

    public function getTotalContributionsAttribute() {
        return $this->participants->sum(function($participant) {
            return $participant->payments->sum('amount');
        });
    }

    public function getTotalExpensesAttribute() {
        return $this->expenses->sum('amount');
    }

}
