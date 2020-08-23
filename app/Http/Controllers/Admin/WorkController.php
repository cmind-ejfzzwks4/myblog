<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// 以下を追記することでWork Modelが扱えるようになる
use App\Work;
// 以下を追記することでHistory Modelが扱えるようになる
use App\History;

use Carbon\Carbon;

class WorkController extends Controller
{
    public function add()
    {
        return view('admin.work.create');
    }

    public function create(Request $request)
    {
        // Varidationを行う
        $this->validate($request, Work::$rules);

        $work = new Work;
        // 送信されてきたフォームデータを格納する
        $form = $request->all();

        // フォームから資料ファイルが送信されてきたら、保存して、$work->file に資料ファイルのパスを保存する
        if (isset($form['file'])) {
            $path = $request->file('file')->store('public/file');
            $work->file = basename($path);
        } else {
            $work->file = null;
        }

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        // フォームから送信されてきたfileを削除する
        unset($form['file']);

        // データベースに保存する
        $work->fill($form);
        $work->save();

        return redirect('admin/work/');
    }

    public function index(Request $request)
    {
        $cond_name = $request->cond_name;
        if ($cond_name != '') {
            // 検索されたら検索結果を取得する
            $posts = Work::where('name', $cond_name)->get();
        } else {
            // それ以外はすべてのニュースを取得する
            $posts = Work::all();
        }
        return view('admin.work.index',['posts'=>$posts, 'cond_name'=>$cond_name]);
    }

    public function edit(Request $request)
    {
        // Work Modelからデータを取得する
        $work = Work::find($request->id);
        if (empty($work)) {
          abort(404);
        }
        return view('admin.work.edit', ['form' => $work]);
    }

    public function update(Request $request)
    {
        // Validationをかける
        $this->validate($request, Work::$rules);
        // Work Modelからデータを取得する
        $work = Work::find($request->input('id'));
        // 送信されてきたフォームデータを格納する
        $form = $request->all();
        if ($request->input('remove')) {
            $form['file'] = null;
        } elseif ($request->file('file')) {
            $path = $request->file('file')->store('public/file');
            $form['file'] = basename($path);
        } else {
            $form['file'] = $work->file;
        }
        unset($form['_token']);
        unset($form['file']);
        unset($form['remove']);
  
        // 該当するデータを上書きして保存する(※省略形)
        $work->fill($form)->save();

        $history = new History;
        $history->work_id = $work->id;
        $history->edited_at = Carbon::now();
        $history->save();
  
        return redirect('admin/work/');
    }

    public function delete(Request $request)
    {
        // 該当するNews Modelを取得
        $news = Work::find($request->id);
        // 削除する
        $news->delete();
        return redirect('admin/work/');
    }  
}