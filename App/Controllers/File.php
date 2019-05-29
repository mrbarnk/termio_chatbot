<?php
/**
 *
 */
// use Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class File extends Controller
{
  public function __construct()
  {
    $this->middleware('Authentication');
  }
  public function path($path)
  {
    // $serve = new Serve;
    $f = F::find($path);

    if ($f) {
      return $this->attachment($f->file_key);
    } else {
      return exit('File  not found.');
    }
  }
  public static function store($image, $path, $type = '')
  {
    // if (empty($path)) {
    //   $path = 'uploaded';
    // }
    // code...
    // $request = new Request;
    // $request = $request::capture();
    // $image = $request->file('file');
    if($image) {
    $imageName = $image->getClientOriginalName();
    // if($request->wantsJson()) {
      // $image->move(url('postimages'), $image);
      $ext = explode('.', $imageName);
      $ext = strtolower(end($ext));
      
      // $notAlowed = ['java','php','py','js','rb','c','ccp','cpp'];
      // if(in_array($ext,$notAlowed)) {
      //     $exts = 'txt';
      // } else {
          $exts = $ext;
      // }
      // $allowed = array('jpg', 'png', 'jpeg', 'gif');
      // if(in_array($ext, $allowed)) {
          $newname = uniqid('', true).'.'.$exts;
          $moved = ($image->move('uploaded/'.$path.'/'.$ext.'_files/', $newname));

          if (!is_null($type) && $type == 'image') {

            $imagesR =__DIR__.'/../../public/'.$moved;

            if(!@is_array(getimagesize($imagesR))){
              return die('Please upload an image');
            }
          }
          return ($moved);
          // $array = ['link' => url('uploaded/'.$ext.'_files'.$newname)];
          // echo stripslashes(json_encode((object) $array));
          return false;
          // exit;
          }else {
              return '';//Invalid file.';
          }
        // }
      // }
  }
  public static function getFile($name)
  {
    if (!is_null($name)) {
      return Storage::download($name);
    } else {
      return exit('File name cannot be empty.');
    }
  }
}