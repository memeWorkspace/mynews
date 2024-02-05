<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
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


    public function edit()
    {
        return view('admin.profile.edit');
    }

    public function update()
    {
        return redirect('admin/profile/edit');
    }
}