<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VoteCategory extends Model
{
    protected $fillable = ['title', 'slug', 'parent_id', 'description', 'image', 'status'];

    protected $appends = [
        'parent'
    ];

    public function parent()
    {
        return $this->belongsTo('App\Model\VoteCategory', 'parent_id', 'id');
    }

    public function childs() {
        return $this->hasMany('App\Model\VoteCategory','parent_id','id') ;
    }

    public function getParentsAttribute()
    {
        $parents = collect([]);

        $parent = $this->parent;

        while(!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parent;
        }

        return $parents;
    }

    // GRAND CHIELD CATEGORY FILES DELETION
    public static function deleteGrandChieldImages($grandChield)
    {
        $getChieldData = SELF::find($grandChield);

        if($getChieldData->childs->count() > 0)
        {
            $subChilds = $getChieldData->childs;

            foreach($subChilds as $subChild)
            {
                if (is_file(public_path('storage/uploads/vote-categories/'.$subChild->image))) {
                    unlink(public_path('storage/uploads/vote-categories/'.$subChild->image));
                }
                SELF::deleteGrandChieldImages($subChild->id);
            }
        }

    }

    public function candidates()
    {
        return $this->hasMany('App\Model\Candidate');
    }

    public function votes()
    {
        return $this->hasMany('App\Model\Vote');
    }
    // EVENT FOR DELETING ASSOCIATED IMAGE WITH Candidate UNDER DELETED CATEGORY AND IMAGE WITH CHILD CATEGORY UNDER A CATEGORY
    protected static function boot() {
        parent::boot();

        static::deleting(function($VoteCategory) {
            if($VoteCategory->candidates->count() > 0)
            {
                $candidates = $VoteCategory->candidates;
                foreach($candidates as $candidate)
                {
                    if (is_file(public_path('storage/uploads/candidates/'.$candidate->image))) {
                        unlink(public_path('storage/uploads/candidates/'.$candidate->image));
                    }
                }
            }

            // do all of the logic for deleting child categories and files here
            if($VoteCategory->childs->count() > 0)
            {
                $childs = $VoteCategory->childs;
                foreach($childs as $child)
                {
                    if (is_file(public_path('storage/uploads/vote-categories/'.$child->image))) {
                        unlink(public_path('storage/uploads/vote-categories/'.$child->image));
                    }

                    $getChieldData = SELF::deleteGrandChieldImages($child->id);
                }
            }
        });
    }
}
