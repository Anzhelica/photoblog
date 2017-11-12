<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class LikeController extends Controller
{
    public function doLike(Request $request, $photo_id)
    {
      $user_id = Auth::user()->id;
      $check = Like::where('photo_id', $photo_id)->where('user_id', $user_id)->count();
      if($check==0){
        $like = new Like();
        $like->photo_id = $photo_id;
        $like->user_id = $user_id;
        $like->save();
        return ['result' => 'You like it'];
      } else{
        return['result' => 'You have already liked it'];
      }
    }
    public  function doUnLike(Request $request, $photo_id){
      $user_id = Auth::user()->id;
      return Like::where('photo_id', $photo_id)->where('user_id', $user_id)->delete();

    }
}
