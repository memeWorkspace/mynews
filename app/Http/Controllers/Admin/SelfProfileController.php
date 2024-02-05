<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\ProfileHistory;
use App\Models\Profile;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SelfProfileController extends Controller
{
    //
    public function add()
    {
        return view('admin.profile.create');
    }

    public function create(ProfileRequest $request)
    {
        $news = new Profile();
        $form = $request->all();

        unset($form['_token']);

        $news->fill($form);
        $news->save();

        return redirect('admin/profile');
    }

    public function index(Request $request)
    {
        $cond_title = $request->cond_title;
        if ($cond_title !=''){

            $posts = Profile::where('title',$cond_title)->get();

        } else {
            
            $posts = Profile::all();
        }
        return view('admin.profile.index', ['posts' => $posts, 'cond_title' => $cond_title]);
    }


    public function edit(Request $request)
    {
        $profile = Profile::find($request->id);
        if (empty($profile)) {
            abort(404);
        }
        return view('admin.profile.edit', ['profile_form' => $profile]);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $profile = Profile::find($request->id);

        $profile_form = $request->all();

        unset($profile_form['_token']);

        $profile->fill($profile_form)->save();

        $history = new ProfileHistory;
        $history->profile_id = $profile->id;
        $history->edited_at = Carbon::now();
        $history->save();


        return redirect('admin/profile');
    }

    public function delete(Request $request)
    {
        $profile = Profile::find($request->id);

        $profile->delete();

        return redirect('admin/profile');
    }
}