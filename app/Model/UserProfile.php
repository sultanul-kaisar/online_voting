<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','phone','address', 'facebook', 'twitter'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
