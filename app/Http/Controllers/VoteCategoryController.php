<?php

namespace App\Http\Controllers;

use App\Model\VoteCategory;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Str;
use File;

class VoteCategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:developer|super admin|master|global|vote category view'], ['only' => ['index', 'show']]);
        $this->middleware(['role_or_permission:developer|super admin|master|global|vote category create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:developer|super admin|master|global|vote category edit'],   ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:developer|super admin|master|global|vote category delete'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $voteCategories = VoteCategory::all();

        return view('admin.vote-categories.index', compact('voteCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = VoteCategory::where('status', 'active')->get();
        return view('admin.vote-categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->has('image')){
            $validatedData = $request->validate([
                'parent_id'         => '',
                'title'             => 'required|min:3|max:100',
                'slug'              => 'required|unique:vote_categories',
                'description'       => ''
            ]);

            try {
                $voteCategory = new VoteCategory;
                $voteCategory->create($validatedData);
                return redirect()->route('vote-category.index')->with('successMessage', 'Vote category successfully created!');
            } catch (\Exception $ex) {
                \Artisan::call('cache:clear');
                return redirect()->route('vote-category.index')->with('errorMessage', $ex->getMessage());
            }
        }else{
            $validatedData = $request->validate([
                'parent_id'         => '',
                'title'             => 'required|min:3|max:100',
                'slug'              => 'required|unique:vote_categories',
                'description'       => '',
                'image'             => 'required|image|mimes:jpeg,jpg,png,gif|max:2048'
            ]);

            $imagename =  str_shuffle(Str::random(6)).str_shuffle(Str::random(6)).'-'.date('dmy').'.'.$request->file('image')->extension();

            $image = Image::make($request->image);

            $validatedData['image'] = $imagename;

            try {
                $voteCategory = new VoteCategory;
                if($voteCategory->create($validatedData))
                {
                    $path = public_path('storage/uploads/vote-categories/');

                    if(!File::isDirectory($path)){
                        File::makeDirectory($path, 0777, true, true);
                    }
                    $image->save($path.$imagename);
                    return redirect()->route('vote-category.index')->with('successMessage', 'Vote category successfully created!');
                }

            } catch (\Exception $ex) {
                \Artisan::call('cache:clear');
                return redirect()->route('vote-category.index')->with('errorMessage', $ex->getMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VoteCategory  $voteCategory
     * @return \Illuminate\Http\Response
     */
    public function show(VoteCategory $voteCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VoteCategory  $voteCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(VoteCategory $voteCategory)
    {
        $categories = VoteCategory::where('status', 'active')->get();
        return view('admin.vote-categories.edit', compact('categories', 'voteCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VoteCategory  $voteCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VoteCategory $voteCategory)
    {
        if(!$request->has('image')){
            $validatedData = $request->validate([
                'parent_id'         => '',
                'title'             => 'required|min:3|max:100',
                'slug'              => 'required|unique:vote_categories,slug,'.$voteCategory->id,
                'description'       => '',
                'status'            => 'required'
            ]);

            try {
                $voteCategory->update($validatedData);
                return redirect()->route('vote-category.edit', $voteCategory->id)->with('successMessage', 'Vote category successfully updated!');
            } catch (\Exception $ex) {
                \Artisan::call('cache:clear');
                return redirect()->route('vote-category.index')->with('errorMessage', $ex->getMessage());
            }
        }else{
            $validatedData = $request->validate([
                'parent_id'         => '',
                'title'             => 'required|min:3|max:100',
                'slug'              => 'required|unique:vote_categories,slug,'.$voteCategory->id,
                'description'       => '',
                'image'             => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
                'status'            => 'required'
            ]);

            $imagename =  str_shuffle(Str::random(6)).str_shuffle(Str::random(6)).'-'.date('dmy').'.'.$request->file('image')->extension();

            $image = Image::make($request->image);

            $validatedData['image'] = $imagename;

            $oldImage = $voteCategory->image;
            try {
                if($voteCategory->update($validatedData))
                {
                    $path = public_path('storage/uploads/vote-categories/');

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
                    return redirect()->route('vote-category.edit', $voteCategory->id)->with('successMessage', 'Vote category successfully updated!');
                }

            } catch (\Exception $ex) {
                \Artisan::call('cache:clear');
                return redirect()->route('vote-category.index')->with('errorMessage', $ex->getMessage());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VoteCategory  $voteCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(VoteCategory $voteCategory)
    {
        $oldImage = $voteCategory->image;

        if($voteCategory->delete())
        {
            $path = public_path('storage/uploads/vote-categories/');
            if($oldImage != 'default.jpg')
            {
                if (is_file($path.$oldImage)) {
                    unlink($path.$oldImage);
                }
            }

            return redirect()->route('vote-category.index')->with('successMessage', 'Vote category successfully deleted!');
        }
    }
}
