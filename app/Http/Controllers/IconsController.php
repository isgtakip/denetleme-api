<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Icons;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\IconsResource;
use Illuminate\Support\Facades\DB;


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
        $q=DB::table('icons')->where('default_icon_set', '=', false)->get();
        return response()->json(IconsResource::collection($q),200);
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

            return response()->json(['error'=>$validator->errors()], 413);
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


                    /*
                                $year = date("Y");   
                    $month = date("m");   
                    $filename = "../".$year;   
                    $filename2 = "../".$year."/".$month;

                    if(file_exists($filename)){
                        if(file_exists($filename2)==false){
                            mkdir($filename2,0777);
                        }
                    }else{
                        mkdir($filename,0777);
                    }
                    */

            return response()->json([
                "success" => true,
                "message" => "File successfully uploaded",
                "file" =>  [             'icon_id' => $save->icon_id,
                                          'icon_name' => $save->icon_name,
                                          'icon_url' => 'http://localhost:8000/storage/files/'.$save->icon_url,
                                          'created_at' => (string) $save->created_at,
                                          'updated_at' => (string) $save->updated_at
                                          ]
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
