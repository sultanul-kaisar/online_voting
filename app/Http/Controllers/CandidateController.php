<?php

namespace App\Http\Controllers;

use App\Model\Candidate;
use App\Model\VoteCategory;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Str;
use File;

class CandidateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:developer|super admin|master|global|candidate view'],   ['only' => ['index', 'show']]);
        $this->middleware(['role_or_permission:developer|super admin|master|global|candidate create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:developer|super admin|master|global|candidate edit'],   ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:developer|super admin|master|global|candidate delete'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $candidates = Candidate::all();

        return view('admin.candidates.index', compact('candidates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = VoteCategory::where('status', 'active')->get();
        return view('admin.candidates.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('image'))
        {
            $validatedData = $request->validate([
                'name'                 => 'required',
                'slug'                 => 'required|unique:candidates',
                'vote_category_id'     => 'required|numeric',
                'description'          => '',
                'image'                => 'required|image|mimes:jpeg,jpg,png,gif|max:2048'
            ]);
            $imagename =  str_shuffle(Str::random(6)).str_shuffle(Str::random(6)).'-'.date('dmy').'.'.$request->file('image')->extension();

            $image = Image::make($request->image)->resize(500, 400);

            $validatedData['image'] = $imagename;

            try {
                $candidate = new Candidate();
                $candidate->create($validatedData);
                $path = public_path('storage/uploads/candidates/');

                if(!File::isDirectory($path)){
                    File::makeDirectory($path, 0777, true, true);
                }

                $image->save($path.$imagename);

                return redirect()->route('candidate.index')->with('successMessage', 'Candidate successfully created!');

            } catch (\Exception $ex) {
                \Artisan::call('cache:clear');
                return redirect()->route('candidate.index')->with('errorMessage', $ex->getMessage());
            }
        }else{

            $validatedData = $request->validate([
                'name'                 => 'required',
                'slug'                 => 'required|unique:candidates',
                'vote_category_id'     => 'required|numeric',
                'description'          => '',
                'image'                => ''
            ]);

            try {
                $candidate = new Candidate();
                $candidate->create($validatedData);
                return redirect()->route('candidate.index')->with('successMessage', 'Candidate successfully created!');

            } catch (\Exception $ex) {
                \Artisan::call('cache:clear');
                return redirect()->route('candidate.index')->with('errorMessage', $ex->getMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function show(Candidate $candidate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function edit(Candidate $candidate)
    {
        $categories = VoteCategory::where('status', 'active')->get();
        return view('admin.candidates.edit', compact('categories', 'candidate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Candidate $candidate)
    {
        if($request->has('image'))
        {
            $validatedData = $request->validate([
                'status'               => 'required',
                'name'                 => 'required',
                'slug'                 => 'required|unique:candidates,slug,'.$candidate->id,
                'vote_category_id'     => 'required|numeric',
                'description'          => '',
                'image'                => 'required|image|mimes:jpeg,jpg,png,gif|max:2048'
            ]);
            $imagename =  str_shuffle(Str::random(6)).str_shuffle(Str::random(6)).'-'.date('dmy').'.'.$request->file('image')->extension();

            $image = Image::make($request->image)->resize(500, 400);

            $validatedData['image'] = $imagename;

            try {
                $oldImage = $candidate->image;
                $candidate->update($validatedData);
                $path = public_path('storage/uploads/candidates/');

                if(!File::isDirectory($path)){
                    File::makeDirectory($path, 0777, true, true);
                }

                if($oldImage != 'default.jpg')
                {
                    if (is_file($path.$oldImage)) {
                        unlink($path.$oldImage);
                    }
                }

                $image->save($path.$imagename);

                return redirect()->route('candidate.edit', $candidate->id)->with('successMessage', 'Candidate successfully updated!');

            } catch (\Exception $ex) {
                \Artisan::call('cache:clear');
                return redirect()->route('candidate.index')->with('errorMessage', $ex->getMessage());
            }
        }else{

            $validatedData = $request->validate([
                'status'               => 'required',
                'name'                 => 'required',
                'slug'                 => 'required|unique:candidates,slug,'.$candidate->id,
                'vote_category_id'     => 'required|numeric',
                'description'          => '',
                'image'                => ''
            ]);

            try {
                $candidate->update($validatedData);
                return redirect()->route('candidate.edit', $candidate->id)->with('successMessage', 'Candidate successfully updated!');

            } catch (\Exception $ex) {
                \Artisan::call('cache:clear');
                return redirect()->route('candidate.index')->with('errorMessage', $ex->getMessage());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Candidate $candidate)
    {
        $oldImage = $candidate->image;

        if($candidate->delete())
        {
            $path = public_path('storage/uploads/candidates/');
            if($oldImage != 'default.jpg')
            {
                if (is_file($path.$oldImage)) {
                    unlink($path.$oldImage);
                }
            }

            return redirect()->route('candidate.index')->with('successMessage', 'Candidate successfully deleted!');
        }
    }
}
