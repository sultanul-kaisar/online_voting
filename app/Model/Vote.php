<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['user_id', 'candidate_id', 'vote_category_id'];

    public function vote_category()
    {
        return $this->belongsTo('App\Model\VoteCategory');
    }

    public function candidate()
    {
        return $this->belongsTo('App\Model\Candidate');
    }

    public function users()
    {
        return $this->hasMany('App\Model\User');
    }
}
