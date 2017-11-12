<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    public static function getMyBestAlbum(){
      return Album::where('name','LIKE','%am%')->get();
}
  public static function lates(){
    return Album::orderby('id', 'desc')->first();
  }
}

