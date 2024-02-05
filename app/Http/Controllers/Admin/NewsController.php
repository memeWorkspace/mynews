<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\NewsRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\News;

class NewsController extends Controller
{
    //
    public function add()
    {
        return view("admin.news.create");
    }

    
    public function create(NewsRequest $request)
    {
        //Newsモデルをインスタンス化
        $news = new News();
        //フォームで入力された内容を全て$formに格納
        $form = $request->all();

        // フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
        if (isset($form['images'])) {
            $path = $request->file('image')->store('public/image');
            $news->image_path = basename($path);
        } else {
            $news->image_path = null;
        };

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        // フォームから送信されてきたimageを削除する
        unset($form['image']);

        // データベースに保存する
        $news->fill($form);
        $news->save();
        
        return redirect('admin/news/create');
    }

    public function index(Request $request)
    {
        $cond_title = $request->cond_title;
        if ($cond_title !=''){
            //検索されたら結果を取得
            $posts = News::where('title',$cond_title)->get();
        } else {
            //それ以外は全てのニュースを取得
            $posts = News::all();
        }
        return view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]);
    }

    public function edit()
    {
        return view('admin.news.edit');
    }

    public function update()
    {
        return redirect('admin/news/edit');
    }

}