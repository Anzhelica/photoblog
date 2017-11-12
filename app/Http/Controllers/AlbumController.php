<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Request;
use App\Album;
use App\Http\Requests;

class AlbumController extends Controller
{
    public function index(){
        $albums = Album::all();
        dd($albums);
    }

    public function create(){
      $data['last_album']=Album::lates();
      return view('album.create',$data);
    }
    public function store(Request $request){
      $this->validate($request,[
        'name' => 'required',
        'photo' => 'required|image'
      ]);
      try{
        DB::transaction(function () use($request){
          $album = new Album();
          $album->name = $request->name;
          $album->save();
          $file = $request->file('photo');
          //dd($file);
          $filename = $album->id.'.'.$file->getClientOriginalExtension();
          $file->move('photos',$filename);
          $album->photo_url='/photos/'.$filename;
          $album->save();
        });


      }catch(Exception $e){
          dd($e->getMessage());
      }
    }

    public function first()
    {
      //$album = Album::find(1);
      $album = Album::getMyBestAlbum();
      dd($album);
    }
}

