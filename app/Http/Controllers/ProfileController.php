<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Profilehistory;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function add()
    {
        return view("admin.profile.create");
    }
    
    public function create(ProfileRequest $request)
    {
        //profileモデルをインスタンス化
        $profile = new Profile();
        //フォームで入力された内容を全て$formに格納
        $form = $request->all();

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);

        // データベースに保存する
        $profile->fill($form);
        $profile->save();

        return redirect('admin/profile');
    }
    /**
     * Display the user's profile form.
     */
    public function index(Request $request)
    {
        $cond_title = $request->cond_title;
        if ($cond_title != '') {
            // 'title' カラムではなく 'name' カラムを使用する
            $posts = Profile::where('name', 'like', '%' . $cond_title . '%')->get();
        } else {
            // それ以外はすべてを取得する
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

    public function update(Request $request)
    {
        $this->validate($request, Profile::$rules);
        $profile = Profile::find($request->input('id'));
        $profile_form = $request->all();

        unset($profile_form['_token']);

        $profile->fill($profile_form)->save();

        $history = new Profilehistory;
        $history->profile_id = $profile->id;
        $history->edited_at = Carbon::now();
        $history->save();

        return redirect('admin/profile/');
    }

    public function delete(Request $request)
    {
        $profile = Profile::find($request->id);
        if(empty($profile)) {
            abort(404);
        }
        $profile->delete();
        return redirect('admin/profile');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}