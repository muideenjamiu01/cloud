<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;
use Illuminate\Support\Facades\Storage;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        if (env('APP_ENV')== 'production')
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $files = Document::where("owner_id", $user->id)->get();
        $trash = Document::onlyTrashed()->where("owner_id", $user->id)->get();
        return view('home', compact('files', 'trash'));
    }

    public function uploadFile(Request $request) {

        if ($request->hasFile('path')) {
            $path = Storage::putFile('str', $request->file('path'));
            $user = Auth::user();
            $f = new Document();
            $f->path = $path;
            $f->title = $request->title;
            $f->owner_id = $user->id;
            $f->size = Storage::size($path);
            $f->save();
            // Storage::delete($user->displaypic);
            return  redirect('/home');
        }
        return  redirect('/home');
    }

    public function removeFIle(Request $request) {
    $file = Document::find($request->fileid);

    if ($file) {
        $file->delete();
       // Storage::delete($request->filename);
    }

    return  redirect('/home');
    }

    public function restoreFile(Request $request){
        $file = Document::onlyTrashed()->find($request->fileid);
        if ($file) {

            $file->restore();
        }

        return  redirect('/home');
    }

    public function downloadFile(Request $request) {
        $file = Document::find($request->fileid);

        if ($file) {

            return Storage::download($file->path);

        }

        return  redirect('/home');

    }
}
