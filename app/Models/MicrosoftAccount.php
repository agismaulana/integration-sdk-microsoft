<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MicrosoftAccount extends Model
{
    use HasFactory;

    protected $table = 'microsoft_users';
    public $fillable = [
        'user_id',
        'microsoft_id',
        'microsoft_email'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
