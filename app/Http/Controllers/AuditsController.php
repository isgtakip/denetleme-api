<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Audits;
use Illuminate\Support\Facades\DB;

class AuditsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        /*
        SELECT 
        count(q.question_id) as total_question, 
        count(answers.answer_option_id) as total_answered_questions,
        (count(answers.answer_option_id)/count(q.question_id)*100) as tamamlanma_orani,
        firm.firma_id,firm.firma_tam_unvan,il.title,ilce.name,u.user_id,q.question_id,loc.audit_location_id FROM `audits` 
        left join audits_locations as loc on loc.audit_id=audits.audit_id
        left join firms as firm on firm.firma_id=loc.location_id
        left join audit_locations_users as u on u.audit_location_id=loc.audit_location_id
        left join audits_locations_sablons as sablon on sablon.audit_location_id=loc.audit_location_id
        left join audits_form as form on form.audit_form_id=sablon.sablon_id
        left join audit_form_sections as section on section.audit_form_id=sablon.sablon_id
        left join questions as q on q.section_id=section.section_id
        left join audits_answers as answers on answers.audit_location_id=loc.audit_location_id and answers.question_id=q.question_id
        left join il as il on il.id=firm.firma_il_id
        left join ilce as ilce on ilce.id=firm.firma_ilce_id
        where q.up_question_id=0
        group by loc.audit_location_id;
        */
        //



        $search = $request->query('search');

        $audits = 
        DB::table('audits')
        ->select(DB::raw('
        (count(answers.answer_option_id)/count(q.question_id)*100) as tamamlanma_orani,
        firm.firma_id,firm.firma_tam_unvan,firm.firm_adres,
        il.title as il,ilce.name as ilce,
        u.user_id,
        audits.status,
        loc.audit_location_id,
        audits.start_date,(CASE
        WHEN audits.start_date > CURDATE() THEN "Planlandı" 
        WHEN audits.start_date <= CURDATE() AND (count(answers.answer_option_id)/count(q.question_id)*100) >= 100 THEN "Tamamlandı"
        WHEN audits.start_date <= CURDATE() AND (count(answers.answer_option_id)/count(q.question_id)*100) < 100 THEN "Devam Ediyor"
        END) AS durum'))
        ->leftJoin('audits_locations as loc','loc.audit_id','=','audits.audit_id')
        ->leftJoin('firms as firm','firm.firma_id','=','loc.location_id')
        ->leftJoin('audit_locations_users as u','u.audit_location_id','=','loc.audit_location_id')
        ->leftJoin('audits_locations_sablons as sablon','sablon.audit_location_id','=','loc.audit_location_id')
        ->leftJoin('audits_form as form','form.audit_form_id','=','sablon.sablon_id')
        ->leftJoin('audit_form_sections as section','section.audit_form_id','=','sablon.sablon_id')
        ->leftJoin('questions as q','q.section_id','=','section.section_id')
        ->leftJoin('audits_answers as answers', function ($leftJoin) {
            $leftJoin->on('answers.audit_location_id', '=', 'loc.audit_location_id')
                 ->on('answers.question_id', '=', 'q.question_id');
         })
        ->leftJoin('il as il','il.id','=','firm.firma_il_id')
        ->leftJoin('ilce as ilce','ilce.id','=','firm.firma_ilce_id')
        ->where("q.up_question_id","=",0)
        ->where(function($query) use ($search) {
            $query->where('firm.firma_tam_unvan', 'like', '%'.$search.'%')
            ->orWhere('firm.firma_kisa_ad', 'like', '%'.$search.'%');
        })
        //->where("audits.status",'=',1)
        ->groupBy('loc.audit_location_id');
        //->get();

        $q = \DB::table(\DB::raw('('.$audits->toSql().') as o1'))
        ->mergeBindings($audits);

        if ($request->status){
            if ($request->status=="Planlanan") $q->where("o1.durum","=","Planlandı");
            if ($request->status=="Devam")  $q->where("o1.durum","=","Devam Ediyor");
            if ($request->status=="Completed")  $q->where("o1.durum","=","Tamamlandı");
            if ($request->status=="Decline")  $q->where("o1.status","=",0);
            if ($request->status=="Active")  $q->where("o1.status","=",1);
        }


        return response()->json($q->paginate(5)->appends(request()->query()),200);
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
        
        $audit = new Audits();
        $audit->title = $request->title;
        $audit->start_date = $request->start_date;
        $audit->end_date = $request->end_date;
        $audit->period = $request->period;
        $audit->status = 1;
        $audit->save();
        

        $arr_location_ids = json_decode($request->location_ids, true);
        $arr_sablon_ids = json_decode($request->sablon_ids, true);
        $arr_user_ids = json_decode($request->user_ids, true);

        $arr2=[];
        $arr3=[];
        $arr4=[];
        

        //tek lokasyon ekleneceği için array 0 olarak alıyoruz
        foreach($arr_location_ids as $location){
            $arr2[] = ['audit_id'=>$audit->audit_id,'location_id'=>$location['location_id']];  
        }
        
        $audit_location_id = DB::table('audits_locations')->insertGetId($arr2[0]);

        //diğer işlemleri audit location id üzerinden yapacaz buda tek değer olacak o yüzden çoklu kayıt yok 
        //
        foreach ($arr_sablon_ids as $sablon){
            $arr3[]= ['audit_location_id'=>$audit_location_id,'sablon_id'=>$sablon['audit_form_id']];
        }

        foreach ($arr_user_ids as $user){
            $arr4[]= ['audit_location_id'=>$audit_location_id,'user_id'=>$user['id']];
        }
        

        DB::table('audits_locations_sablons')->insert($arr3);
        DB::table('audit_locations_users')->insert($arr4);
        

        return response()->json("Başarı ile eklendi",200);



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
        $forms = DB::table('audits_locations_sablons as loc')
        ->selectRaw('(count(answer.answer_option_id)/count(question.question_id)*100) as tamamlanma_orani,
        section.section_name,section.section_id,loc.audit_location_id,form.audit_form_id,
        form.audit_form_name,form.audit_form_no,icon.icon_url')
        ->leftJoin('audits_form as form','form.audit_form_id','=','loc.sablon_id')
        ->leftJoin('icons as icon','icon.icon_id','=','form.icon_id')
        ->leftJoin('audit_form_sections as section','section.audit_form_id','=','form.audit_form_id')
        ->leftJoin('questions as question','question.section_id','=','section.section_id')
        ->leftJoin('audits_answers as answer', function ($leftJoin) {
            $leftJoin->on('answer.audit_location_id', '=', 'loc.audit_location_id')
                 ->on('answer.question_id', '=', 'question.question_id');
         })
        ->where("loc.audit_location_id","=",$id)
        ->where("question.up_question_id","=",0)
        ->groupBy('loc.sablon_id')
        ->get();

        return response()->json($forms,200);
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
