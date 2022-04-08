<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questions;
use App\Models\QuestionOptions;
use App\Models\AuditsFormModel;
use App\Models\Sections;
use App\Models\Answers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function find_sub_questions($question_id,$loc_id){
        
        $query=Questions::where('up_question_id',$question_id);

        $query->with([
            'answers' => function ($query) use ($loc_id) {
                $query->where('audit_location_id','=', $loc_id);
            },
            'questionoptions.options'
        ]);

        $sub_questions=$query->get();

        if($sub_questions){
        foreach ($sub_questions as $q){ 
                    $q['sub_questions']= $this->find_sub_questions($q->question_id,$loc_id);          
        }}
        return $sub_questions;

    } 

    //delete subquestions answers

    public function show($loc_id,$form_id)
    {
        //

        $forms = AuditsFormModel::find($form_id)->sections()->get();

        $forms->map(function ($form) use($loc_id){

            $query=Questions::where('section_id','=',$form->section_id);
            $query->where('up_question_id',"=",0);

            //ana sorular için answerler ile birlikte getir / ana soruları optionları ile birlikte getir 
            $query->with([
                'answers' => function ($query) use ($loc_id) {
                    $query->where('audit_location_id','=', $loc_id);
                },
                'questionoptions.options'
            ]);

            $ana_sorular=$query->get();

            $ana_sorular->map(function ($q) use ($loc_id){
                        $q['sub_questions']=$this->find_sub_questions($q->question_id,$loc_id);
                        return $q;
            });

            $form['sorular'] =$ana_sorular;
            return $form;
        });

    
        return response()->json($forms,200);

    }

    public function sorulari_al(){


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

    //delete sun questions answers 

    public function find_sub_questions_and_delete_answers($question_id,$loc_id){
        $sub_questions=Questions::where('up_question_id',$question_id)->get();
      
        if($sub_questions){
        foreach ($sub_questions as $q){
                    Answers::where('question_id','=',$q->question_id)
                    ->where('audit_location_id','=',$loc_id)
                    ->delete();

                    $this->find_sub_questions_and_delete_answers($q->question_id,$loc_id);
        }}

    } 

    public function update(Request $request, $loc_id, $fid)
    {

        $this->find_sub_questions_and_delete_answers($request->ana_question_id,$loc_id);
        //
        //echo $request->qoptions;
        $arr = json_decode($request->qoptions, true);
        $arr2=[];

        //sub question cevaplarını sil 
       

        foreach ($arr as $b) {
         if (isset($b['answer_option_id'])){
             //kayıt yoksa ekle 
            Answers::updateOrCreate(
                ['audit_location_id' => $loc_id, 'question_id' => $b['question_id']],
                ['answer_option_id' => $b['answer_option_id'], 'user_id' => auth()->user()->id]
            );
        }
        }
       

        //sorunun son halini geri postla 
        $query=Questions::where('question_id','=',$request->ana_question_id);
        //$query->where('up_question_id',"=",0);

        //ana sorular için answerler ile birlikte getir / ana soruları optionları ile birlikte getir 
        $query->with([
            'answers' => function ($query) use ($loc_id) {
                $query->where('audit_location_id','=', $loc_id);
            },
            'questionoptions.options'
        ]);

        $ana_sorular=$query->get();

        $ana_sorular->map(function ($q) use ($loc_id){
                    $q['sub_questions']=$this->find_sub_questions($q->question_id,$loc_id);
                    return $q;
        });

        //$form['sorular'] =$ana_sorular;
        //return $form;

        return response()->json($ana_sorular[0],200);
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
