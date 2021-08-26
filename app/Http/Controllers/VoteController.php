<?php

namespace App\Http\Controllers;

use App\Model\Candidate;
use App\Model\VoteCategory;
use App\Model\Vote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function result()
    {
        $candidates = Candidate::where('status', 'active')->orderBy('id', 'asc')->get();
        $vote_categories = VoteCategory::where('status', 'active')->orderBy('id', 'asc')->get();
        $votes  = Vote::all();
        return view('admin.result', compact('candidates', 'vote_categories', 'votes'));
    }

    public function count()
    {
        $candidate_id = DB::table('votes')
            ->select('user_id','vote_category_id','candidate_id', DB::raw("SUM(user_id) as total"))
            ->groupBy('candidate_id','vote_category_id')
            ->get();

        dd($candidate_id);
    }
}
