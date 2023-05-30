<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'problem_description',
        'email',
        'phone_number',
        'reference_number',
        'is_open',
    ];

    public function replies()
    {
        return $this->hasMany(SupportReply::class);
    }
}
