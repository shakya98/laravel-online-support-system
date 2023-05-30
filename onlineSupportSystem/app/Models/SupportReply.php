<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportReply extends Model
{
    use HasFactory;

    protected $fillable = ['reply', 'support_ticket_id'];

    public function supportTicket()
    {
        return $this->belongsTo(SupportTicket::class);
    }
}
