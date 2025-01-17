<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalAbuseReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'description', 'photos1', 'photos2', 'photos3', 'photos4', 'photos5', 
        'videos1', 'videos2', 'videos3', 'status', 'reporter_name',
    ];
    

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id')->where('usertype', 'admin');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function meeting()
    {
        return $this->hasOne(Meeting::class, 'animal_abuse_report_id');
    }
}
