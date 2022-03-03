<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditsFormModel;
use App\Models\Icons;
use App\Models\Sections;

class AuditsFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\ResponseW
     */
    public function getAllAuditForms(Request $request){

        $search = $request->query('search');
        $per_page = $request->query('per_page');

        return response()->json(AuditsFormModel::where(function($query) use ($search) {
            $query->where('audits_form.audit_form_name', 'like', '%'.$search.'%')
            ->orWhere('audits_form.audit_form_no', 'like', '%'.$search.'%');
        })
        ->paginate($per_page)->appends(request()->query()),200);
    }
    private function get_audit_forms($id=null){

        if ($id==null){
            $forms=AuditsFormModel::join('icons','icons.icon_id','=','audits_form.audit_form_icon_id')
            ->get(['audits_form.*','icons.icon_id','icons.icon_url']);
        }
        else{
            $forms=AuditsFormModel::join('icons','icons.icon_id','=','audits_form.audit_form_icon_id')
            ->where('audits_form.audit_form_id', $id)
            ->get(['audits_form.*','icons.icon_id','icons.icon_url']);
        }
        return $forms;
    }

    public function index()
    {
        //

        //icon url ile birlikte getir
        $forms=$this->get_audit_forms();
        return response()->json($forms,200);
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
         $forms = new AuditsFormModel();
         $forms->audit_form_name = $request->audit_form_name;
         $forms->audit_form_no = $request->audit_form_no;
         $forms->audit_form_icon_id=$request->audit_form_icon_id;
         $forms->icon_id=$request->audit_form_icon_id;
         $forms->audit_form_score_needed=1;
         $forms->save();

         //section ekle
         $section = new Sections();
         $section->section_name ="Genel";
         $section->section_order=0;
         $section->audit_form_id=$forms->audit_form_id;
         $section->save();


         $form=$this->get_audit_forms($forms->audit_form_id);
         return response()->json($form,200);

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
        $form=$this->get_audit_forms($id);
        return response()->json($form,200);

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
    public function destroy($audit_form_id)
    {
        //
        $form = AuditsFormModel::findOrFail($audit_form_id);
        $icon = Icons::findOrFail($form->icon_id);


        AuditsFormModel::destroy($audit_form_id);
        if ($icon->default_icon_set != 0) $icon->delete();


        return response()->json(['audit_form_id'=>$audit_form_id],200);
    }
}
