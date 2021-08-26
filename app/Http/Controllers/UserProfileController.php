<?php

namespace App\Http\Controllers;

use App\Model\UserProfile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;
use Illuminate\Support\Str;
use File;

class UserProfileController extends Controller
{
    public function index()
    {
        return view('admin.users.setting');
    }

    public function general(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name'                   => 'required'
        ]);

        if(auth()->user()->id != $user->id){
            return redirect()->route('admin.my-account')->with('errorMessage', 'Something went wrong please try again!');
        }

        try {
            $user->update($validatedData);
            return redirect()->route('admin.my-account')->with('successMessage', 'Profile successfully updated!');
        } catch (\Exception $ex) {
            \Artisan::call('cache:clear');
            return redirect()->route('admin.my-account')->with('errorMessage', $ex->getMessage());
        }
    }

    public function avatar(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'avatar'                   => 'required|file|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $imagename =  str_shuffle(Str::random(6)).str_shuffle(Str::random(6)).'-'.date('dmy').'.'.$request->file('avatar')->extension();

        $image = Image::make($request->avatar)->resize(256, 256);

        $validatedData['avatar'] = $imagename;
        try {

            $oldImage = $user->avatar;
            $user->update($validatedData);
            $path = public_path('storage/uploads/users/avatar/');

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

            return redirect()->route('admin.my-account')->with('successMessage', 'Profile avatar successfully updated!');

        } catch (\Exception $ex) {
            \Artisan::call('cache:clear');
            return redirect()->route('admin.my-account')->with('errorMessage', $ex->getMessage());
        }
    }
    public function profile(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'phone'                   => 'required|numeric|digits:11',
            'address'                 => '',
            'facebook'                => '',
            'twitter'                 => '',
            'instagram'               => ''
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        if(auth()->user()->id != $user->id){
            return redirect()->route('admin.my-account')->with('errorMessage', 'Something went wrong please try again!');
        }


        try {

            if(is_null($user->user_profile)){
                $userProfile = new UserProfile();
                $userProfile->create($validatedData);
                return redirect()->route('admin.my-account')->with('successMessage', 'Profile successfully updated!');
            }else{
                $user->user_profile->update($validatedData);
                return redirect()->route('admin.my-account')->with('successMessage', 'Profile successfully updated!');
            }
        } catch (\Exception $ex) {
            \Artisan::call('cache:clear');
            return redirect()->route('admin.my-account')->with('errorMessage', $ex->getMessage());
        }
    }

    public function security(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'old_password' => [
                'required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('Old Password didn\'t match');
                    }
                },
            ],
            'password'               => 'required|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'password_confirmation'  => 'required'
        ]);

        if(auth()->user()->id != $user->id){
            return redirect()->route('admin.my-account')->with('errorMessage', 'Something went wrong please try again!');
        }

        $updated_password['password'] = Hash::make($validatedData['password_confirmation']);

        try {
            $user->update($updated_password);
            return redirect()->route('admin.my-account')->with('successMessage', 'Password successfully updated!');
        } catch (\Exception $ex) {
            \Artisan::call('cache:clear');
            return redirect()->route('admin.my-account')->with('errorMessage', $ex->getMessage());
        }
    }
}
