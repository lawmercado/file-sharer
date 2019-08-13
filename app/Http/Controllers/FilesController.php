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
                $content = file_get_contents($request->file('file')->getPathName());
                
                if( $content ) {
                    $file = new File;
                    $file->name = $name;
                    $file->content = base64_encode($content);
                    $file->mime = $mimetype;
                    $file->category = $request->input('category');
                    $file->user()->associate(Auth::user());

                    if( File::where('name', $file->name)->count() == 0 ) {
                        if( $file->save() ) {
                            return $this->redirectWithSuccessMessage($request, "files/", "The file was successfully uploaded!");
                        }
                    }
                    else
                    {
                        return $this->redirectWithErrorMessage($request, "files/", "The could not be uploaded: The file already exists!");
                    }
                }
                else {
                    return $this->redirectWithErrorMessage($request, "files/", "Error while reading the uploaded file. Try again later.");            
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
            
            $tempFile = tempnam(sys_get_temp_dir(), 'FSF');
            
            if( file_put_contents($tempFile, base64_decode($file->content)) ) {
                return response()->download($tempFile, $file->name);
            }
            else {
                return $this->redirectWithErrorMessage($request, "files/", "Unable to load the file from the database!");
            }
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
                if( $file->delete() ) {
                    return $this->redirectWithSuccessMessage($request, "files/", "The file was successfully deleted!");
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
