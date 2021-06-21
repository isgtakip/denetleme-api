<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator; 
use App\Models\Icons;
use Illuminate\Support\Facades\Storage;


class IconsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json(Icons::get(),200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[ 
            'file' => 'required|mimes:png,jpg,jpeg|max:2048',
        ]);

        if($validator->fails()) {          
             
            return response()->json(['error'=>$validator->errors()], 401);                        
         } 

         if ($file = $request->file('file')) {
            $path = $file->store('public/files');
            $name = $file->getClientOriginalName();

            $filename = pathinfo($path, PATHINFO_FILENAME);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
  
            //store your file into directory and db
            $save = new Icons();
            $save->icon_name = $name;
            $save->icon_url= $filename.".".$extension;
            $save->save();
               
            return response()->json([
                "success" => true,
                "message" => "File successfully uploaded",
                "file" => $save
            ]);
   
        }

    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
