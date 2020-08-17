<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// 以下を追記することでWork Modelが扱えるようになる
use App\Work;

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

        return redirect('admin/work/create');
    }

    public function edit()
    {
        return view('admin.work.edit');
    }

    public function update()
    {
        return redirect('admin/work/edit');
    }
}