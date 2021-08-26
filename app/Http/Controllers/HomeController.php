<?php

namespace App\Http\Controllers;

use App\Model\Candidate;
use App\Model\VoteCategory;
use Illuminate\Http\Request;

use App\Model\Vote;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role_or_permission:voter'],   ['only' => ['index']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $voteCategories = VoteCategory::where('status', 'active')->get();
        $candidates = Candidate::where('status', 'active')->get();
        return view('home', compact('voteCategories', 'candidates'));
    }



    public function vote_submit($slug)
    {
        $voteCategory = VoteCategory::with('candidates')
            ->where('slug', $slug)
            ->firstOrFail();

        $candidates = Candidate::where('vote_category_id', $voteCategory->id)
                        ->where('status', 'active')->get();
        $checkVote = Vote::where('user_id', Auth::user()->id)
                          ->where('vote_category_id', $voteCategory->id)
                          ->first();

        if(!is_null($checkVote))
        {
            $voted = true;
        }else{
            $voted = false;
        }
        return view('vote_submit', compact('voteCategory','candidates', 'voted'));
    }

    public function votecreate(Request $request)
    {
        //dd($request->all());

        $validatedData = $request->validate([
            'candidate_id'     => 'required'
        ]);

        $validatedData['user_id'] = Auth::user()->id;
        $validatedData['vote_category_id'] = $request->vote_category_id;

        try {
            $vote = new Vote();
            $vote->create($validatedData);

            return redirect()->route('vote_submit', $request->vote_category_slug)->with('successMessage', 'Vote successfully submitted!');

        } catch (\Exception $ex) {
            \Artisan::call('cache:clear');
            return redirect()->route('vote_submit', $request->vote_category_slug)->with('errorMessage', $ex->getMessage());
        }
    }
}
