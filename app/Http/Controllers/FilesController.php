<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Database\PDOException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FilesController extends Controller
{
    public function __construct()
    {

    }

    public function create(Request $request) {
        if($request->hasFile('file')) {
            if($request->file('file')->isValid()) {
                $filename = $request->file('file')->getClientOriginalName();
                $mimetype = $request->file('file')->getClientMimeType();
                $destinationPath = storage_path('uploaded');

                $name = $request->input('name');
                $name = $name != "" ? $name : $filename;

                $file = new File;
                $file->name = $name;
                $file->path = "uploaded/" . $name;
                $file->mime = $mimetype;
                $file->category = $request->input('category');
                $file->user()->associate(Auth::user());

                if( File::where('name', $file->name)->count() == 0 ) {
                    if( $file->save() ) {
                        $request->file('file')->move($destinationPath, $name);

                        return $this->redirectWithSuccessMessage($request, "files/", "The file was successfully uploaded!");
                    }
                }
                else
                {
                    return $this->redirectWithErrorMessage($request, "files/", "The could not be uploaded: The file already exists!");
                }
            }
        }

        return $this->redirectWithErrorMessage($request, "files/", "Unable to upload the file. Try again later.");
    }

    public function update(Request $request, $id) {
        $user = $request->user();

        if( File::where('id', $id)->count() > 0 ) {
            $file = File::where('id', $id)->first();
            
            if( $user->isAdmin() || $user->id === $file->user->id )
            {
                if( $request->isMethod('post') ) {
                    $oldname = $file->name;
                    $name = $request->input('name');
                    $name = $name != "" ? $name : $oldname;
    
                    $file->name = $name;
                    $file->category = $request->input('category');
    
                    if( $name != $oldname ) {
                        $newpath = 'uploaded/' . $name;
                        rename(storage_path($file->path), storage_path($newpath));
                        $file->path = $newpath;
                    }
    
                    if( $file->save() ) {
                        return $this->redirectWithSuccessMessage($request, "files/", "File sucessfully updated!");
                    }
    
                    return $this->redirectWithErrorMessage($request, "files/", "The file could not be updated!");
                }
                else {
                    return view('files/update')->with(["f" => $file]);
                }   
            }

            return $this->redirectWithErrorMessage($request, "files/", "You have no permission to update this file!");
        }
        else {
            return $this->redirectWithErrorMessage($request, "files/", "The file does not exists!");
        }
    }

    public function download($id) {
        if( File::where('id', $id)->count() > 0 ) {
            $file = File::where('id', $id)->first();
            
            $fullpath = storage_path($file->path);

            return response()->download($fullpath);
        }
        else {
            return $this->redirectWithErrorMessage($request, "files/", "The file does not exists!");
        }
    }

    public function list() {
        return view('files/list')->with('files', File::all());
    }

    public function delete(Request $request, $id) {
        $user = $request->user();

        if( File::where('id', $id)->count() > 0 ) {
            $file = File::where('id', $id)->first();
            
            if( $user->isAdmin() || $user->id === $file->user->id )
            {
                $fullpath = storage_path($file->path);

                if( file_exists($fullpath) ) {
                    if( unlink($fullpath) ) {
                        $file->delete();

                        return $this->redirectWithSuccessMessage($request, "files/", "The file was successfully deleted!");
                    }
                }
            }
            else {
                return $this->redirectWithErrorMessage($request, "files/", "You have no permission to delete this file!");
            }
        }
        else {
            return $this->redirectWithErrorMessage($request, "files/", "The file does not exists!");
        }
        
        return $this->redirectWithErrorMessage($request, "files/", "The file could not be removed!");
    }
}
