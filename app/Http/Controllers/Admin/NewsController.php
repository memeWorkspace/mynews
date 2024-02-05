<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
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

    public function edit()
    {
        return view('admin.news.edit');
    }

    public function update()
    {
        return redirect('admin/news/edit');
    }
}