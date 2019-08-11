<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Database\PDOException;
use Illuminate\Support\Facades\Storage;

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

                if( File::where('name', $file->name)->count() == 0 ) {
                    if( $file->save() ) {
                        $request->file('file')->move($destinationPath, $name);

                        return response("The file was successfully uploaded!", 201);
                    }
                }
                else
                {
                    return response()->json([
                        "error" => "The could not be uploaded: The file already exists!"
                    ], 400);
                    
                }
            }
        }

        return response()->json([
            "error" => 'Unable to upload the file. Try again later.'
        ], 500);
    }

    public function update(Request $request, $id) {
        if( File::where('id', $id)->count() > 0 ) {
            $file = File::find($id);
            
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
                    return response("File sucessfully updated!", 200);
                }

                return response()->json([
                    "error" => "The file could not be updated!"
                ], 500);
            }
            else {
                return view('files/update')->with(["f" => $file]);
            }
        }
        else {
            return response()->json([
                "error" => "The file does not exists!"
            ], 400);
        }
    }

    public function download($id) {
        if( File::where('id', $id)->count() > 0 ) {
            $file = File::find($id);
            
            $fullpath = storage_path($file->path);

            return response()->download($fullpath);
        }
        else {
            return response()->json([
                "error" => "The file does not exists!"
            ], 400);
        }
    }

    public function list() {
        return view('files/list')->with('files', File::all());
    }

    public function delete($id) {
        if( File::where('id', $id)->count() > 0 ) {
            $file = File::find($id);
            
            $fullpath = storage_path($file->path);

            if( file_exists($fullpath) ) {
                if( unlink($fullpath) ) {
                    $file->delete();

                    return response("The file was successfully deleted!", 200);
                }
            }
        }
        else {
            return response()->json([
                "error" => "The file does not exists!"
            ], 400);
            
        }
        
        return response()->json([
            "error" => "The file could not be removed!"
        ], 500);
    }
}
