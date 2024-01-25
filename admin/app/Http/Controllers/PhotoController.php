<?php

namespace App\Http\Controllers;

use App\Models\PhotoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    function PhotoIndex(){
        return view('Photo');
    }

    function photoDelete(Request $request){
        $oldPhotoURL = $request->input('oldPhotoURL');
        $oldPhotoId = $request->input('id');

        $oldPhotoURLArray = explode('/', $oldPhotoURL);
        $oldPhotoName = end($oldPhotoURLArray);

        $deletePhotoFile = Storage::delete('/public'.$oldPhotoName);
        $deleteRow = PhotoModel::where('id', '=', $oldPhotoId)->delete();
        return $deleteRow;
    }

    function photoJSON(Request $request){
        return PhotoModel::take(4)->get();
    }

    function photoJSONById(Request $request){
        $firstId = $request->id;
        $lastId = $firstId+4;
        return PhotoModel::where('id', '>=', $firstId)->where('id', '<', $lastId)->get();
    }

    function photoUpload(Request $request){
        $photoPath = $request->file('photo')->store('public');
        $photoName = (explode('/', $photoPath))[1];
        $host = $_SERVER['HTTP_HOST'];
        $location="http://".$host."/storage/".$photoName;
        $result = PhotoModel::insert(['location'=>$location]);
        return $result;
    }
}
