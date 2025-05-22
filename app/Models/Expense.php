<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'category', 'description', 'amount', 'expense_date'];

    protected $casts = [
        'expense_date' => 'date',
    ];

    public function event() {
        return $this->belongsTo(Event::class);
    }
}
