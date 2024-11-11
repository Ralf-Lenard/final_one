<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMeeting extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural form of the model name
    protected $table = 'user_meetings'; 

    // Specify the fillable properties
    protected $fillable = [
        'user_id',
        'meeting_id',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
