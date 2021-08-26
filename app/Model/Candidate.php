<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = ['name', 'slug', 'vote_category_id', 'description', 'image', 'status'];

    public function vote_category()
    {
        return $this->belongsTo('App\Model\VoteCategory');
    }

    public function vote()
    {
        return $this->hasMany('App\Model\Vote');
    }
}
