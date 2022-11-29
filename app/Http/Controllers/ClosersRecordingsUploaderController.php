<?php

namespace App\Http\Controllers;

use App\Tmoffer;
use App\TmofferRecordings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClosersRecordingsUploaderController extends Controller
{
    private $dir='/closers-calls';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        $dir='/Backup';
//        Storage::disk('dropbox')->makeDirectory($dir);
        $files = Storage::disk('dropbox')->files($this->dir);
//        dd($files[0]);
//        $files=[];
//        for ($i=0;$i<100;$i++)
//            $files[]=$__files[$i];
        return view('closers-recordings.index',compact('files'));

//        $url = Storage::disk('dropbox')->url($files[0]);
//        dd($url);
//        echo 'hi!';
    }

    public function showTmofferRecordings(Request $request){
        $tmoffer_recordings=TmofferRecordings::where('tmoffer_id',$request->id)->get();
        $files=[];
        if(count($tmoffer_recordings))
            foreach ($tmoffer_recordings as $tmoffer_recording)
                $files[]=$this->dir.'/'.$tmoffer_recording->filename;
        return view('closers-recordings.index',compact('files'));
    }

    public function uploadCall(Request $request){
        $paths=[];
        foreach ($request->file('tmf-file') as $file)
//            $paths[]=Storage::disk('dropbox')->put($this->dir.'/'.$file->getClientOriginalName(),$file);
            $paths[]=$file->storeAs($this->dir,$file->getClientOriginalName(),'dropbox');
        return implode('\r\n',$paths);
    }

    public function removeCall(Request $request){
        if($request->call) {
            Storage::disk('dropbox')->delete($request->call);
            TmofferRecordings::where('filename',basename($request->call))->delete();
            return 'DONE';
        }
        return '';
    }

}
