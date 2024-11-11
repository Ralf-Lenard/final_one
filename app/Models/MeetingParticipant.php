<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingParticipant extends Model
{
    use HasFactory;

    // Specify the table associated with the model
    protected $table = 'meeting_participants';

    // Specify the fillable attributes
    protected $fillable = [
        'meeting_id',
        'user_id',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the UserMeeting model
    public function userMeeting()
    {
        return $this->belongsTo(UserMeeting::class, 'meeting_id');
    }
}
