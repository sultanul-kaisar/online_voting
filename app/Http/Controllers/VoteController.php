<?php

namespace App\Http\Controllers;

use App\Model\Candidate;
use App\Model\VoteCategory;
use App\Model\Vote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    public function result()
    {
        $voteResults = Vote::with('candidate', 'vote_category')->select('vote_category_id','candidate_id', DB::raw("count(candidate_id) as total"))
            ->groupBy('vote_category_id', 'candidate_id')
            ->get();
        return view('admin.result', compact('voteResults'));
    }
}
