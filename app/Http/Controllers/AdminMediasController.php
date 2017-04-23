<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Photo;
class AdminMediasController extends Controller
{
    //

    public function index()
    {
    	# 

    	$photos = Photo::all();
    	return view('admin.media.index', compact('photos'));
    }

    public function show($id)
    {
    	return view('admin.media.upload');

    }

    public function create()
    {
    	 return view('admin.media.upload');
    }

    public function store(Request $request)
    {
    	#
    	$file = $request->file('file');

        $name = time() . $file->getClientOriginalName();

        $file->move('images', $name);


    	Photo::create(['file'=>$name]);

    	// return redirect('/admin/media/')
    }

    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);

        unlink(public_path() . $photo->file);

        $photo->delete();
        
            return redirect('/admin/media');
    }
}
