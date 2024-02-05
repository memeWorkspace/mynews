<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Models\News;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\History;

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
        if (isset($form['image'])) {
            $path = $request->file('image')->store('public/image');
            $news->image_path = basename($path);
            unset($form['image']);
            //画像削除のてチェックボックスにチェックがついたら処理される
        } elseif (0 == strcmp($request->remove, 'true')) {
            $news->image_path = null;
        }

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        // フォームから送信されてきたimageを削除する
        unset($form['image']);

        // データベースに保存する
        $news->fill($form);
        $news->save();

        return redirect('admin/news');
    }

    public function index(Request $request)
    {
        $cond_title = $request->cond_title;
        if ($cond_title != '') {
            // 検索されたら検索結果を取得する
            $posts = News::where('title', $cond_title)->get();
        } else {
            //それ以外は全てのニュースを取得
            $posts = News::all();
        }

        if ($cond_title != '') {
            $posts = News::where('title', $cond_title)->orderBy('updated_at', 'desc')->get();
        } else {
            $posts = News::all()->sortByDesc('updated_at');
        }
        if (count($posts) > 0) {
            $headline = $posts->shift();
        } else {
            $headline = null;
        }
        return view('admin.news.index', ['headline' => $headline, 'posts' => $posts, 'cond_title' => $cond_title]);
    }

    public function edit(Request $request)
    {
        // News Modelからデータを取得する
        $news = News::find($request->id);
        if (empty($news)) {
            abort(404);
        }
        return view('admin.news.edit', ['news_form' => $news]);
    }

    public function update(Request $request)
    {
        $this->validate($request, News::$rules);
        $news = News::find($request->input('id'));
        $news_form = $request->all();

        if ($request->input('remove')) {
            $news_form['image_path'] = null;
        } elseif ($request->file('image')) {
            $path = $request->file('image')->store('public/image');
            $news_form['image_path'] = basename($path);
        } else {
            $news_form['image_path'] = $news->image_path;
        }

        unset($news_form['_token']);
        unset($news_form['image']);
        unset($news_form['remove']);

        $news->fill($news_form)->save();

        // 以下を追記
        $history = new History;
        $history->news_id = $news->id;
        $history->edited_at = Carbon::now();
        $history->save();

        return redirect('admin/news/');
    }

    public function delete(Request $request)
    {
        // 該当するNews Modelを取得
        $news = News::find($request->id);
        // 削除する
        $news->delete();
        return redirect('admin/news/');
    }

    public function list(Request $request)
    {
        $cond_title = $request->cond_title;
        if ($cond_title != '') {
            $posts = News::where('title', $cond_title)->orderBy('updated_at', 'desc')->get();
        } else {
            $posts = News::all()->sortByDesc('updated_at');
        }
        if (count($posts) > 0) {
            $headline = $posts->shift();
        } else {
            $headline = null;
        }

        return view('news.index', ['headline' => $headline, 'posts' => $posts, 'cond_title' => $cond_title]);
    }
}