<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SentEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'to',
        'subject',
        'customer_name',
        'request_type',
        'reference_id',
        'message_text',
        'html_body',
        'plain_text_body',
        'status',
        'smtp_message_id',
        'error',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
