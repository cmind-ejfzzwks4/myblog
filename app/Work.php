<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'name' => 'required',
    );

    // Workモデルに関連付けを行う
    public function histories()
    {
        return $this->hasMany('App\History');
    }
}
