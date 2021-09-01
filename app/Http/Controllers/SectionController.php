<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sections;
use Illuminate\Support\Arr;
use Mavinoo\LaravelBatch\LaravelBatchFacade as Batch;





class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * 
     */

  

    public function index($audit_form)
    {
        //
        $sections = Sections::where('audit_form_id', $audit_form)
               ->orderBy('section_order')
               ->get();
        return response()->json($sections,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$audit_form)
    {
        //
        return $request;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$audit_form)
    {
        //
        $arr = json_decode($request->sections, true);
      // print_r($arr);
        $arr2=[];
        $i=0;
        foreach ($arr as $b) {
            //assign child-array to newly create array variable
            $arr2[] =  ['section_id'=>$b['section_id'],'section_order'=>$i];  
            $i++;
        }
        $userInstance = new Sections;
        $index = 'section_id';

       batch()->update($userInstance, $arr2, $index);

       return $arr2;
        
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
    public function update(Request $request, $section_id)
    {
        //
        $section = Sections::find($section_id);
        $section->section_name = $request->section_name;
        $section->update();
        
        //firma bilgileri geri döndürülecek daha sonra 
        return response()->json($section,200);
        
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($section_id)
    {
        //
        Sections::destroy($section_id); 
        return response()->json(['section_id'=>$section_id],200);
    }

    public function addSections(Request $request){

        $section = new Sections();
        $section->section_name = $request->section_name;
        $section->audit_form_id=$request->audit_form_id;
        $section_order= Sections::where('audit_form_id', (int)$request->audit_form_id)->max('section_order');
        $section_order++;
        $section->section_order=$section_order;
        $section->save();

        return response()->json($section,200);
    }
}
