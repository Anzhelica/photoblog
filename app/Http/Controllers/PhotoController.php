<?php

namespace App\Http\Controllers;
use App\Album;
use App\Photo;
use Illuminate\Http\Request;

use App\Http\Requests;
use Mockery\Exception;
use function public_path;

class PhotoController extends Controller
{
   public function  store(Request $request, $album){
     $user = Auth::user();

     $albumdata = Album::find($album);
     if($user->id != $albumdata->user_id){
       return['error'=>'auth error'];
     }
     $this->validate($request, [
       'cover'=>'required|image'
     ]);

     $result = ['status' =>'success'];
     $photo = new Photo();
     $photo->user_id = $user->id;
     $photo->name = "Фотография без названия";
     $photo->album_id = $album;
     $photo->save();

     try{
       $extention = Fille::extension($request->file('cover')->getClientOriginalName());
       $file = $request->file('cover')->move('uploads/pictures/', $photo->id . '.'. $extention);
       $thumb = '/uploads/pictures/thumbs'.$photo->id . '.' . $extention;
       Image::make($file)->resize(400, null, function ($constaint){
         $constaint->aspectRatio();
       })->save(public_path().$thumb);

       $filename = '/' . $file->__toString() . '?' . time();
       $photo->url = filename;
       $photo->thumb = $thumb;
       $photo->save();
     }
     catch (Exception $e){
       $photo->delete();
       return['status' => error];
     }
     $result['photo_id'] = $photo->id;
     $ult['photo'] = $filename;
     $ult['thumb'] = $thumb;
     $ult['num'] = $request->input('num');
     return $result;

   }
   public function update(Request $request, $id){
     try{
       $photo = Photo::find($id);
       $user = Auth::user();
       if($user->id != $photo->user_id){
         return ['error' =>'auth error'];
       }
       $photo->name = $request->input('name');
       $photo->description = $request->input('description');
       $photo->save();
       return['id' =>$id, 'desc'=>$photo->name, 'status' =>'PHOTO edited sucsessfully'];

     }catch (Exception $e){

     }
   }
}
