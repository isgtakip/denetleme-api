<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questions;
use App\Models\QuestionOptions;
use App\Models\OptionSets;
use App\Models\Options;
use Illuminate\Support\Arr;
use Mavinoo\LaravelBatch\LaravelBatchFacade as Batch;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\QuestionsResource;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($section_id)
    {
        //
        /*$questions = Questions::where('section_id', $section_id)
        ->where('up_question_id',0)
        ->orderBy('question_order')
        ->get();
        */

        $questions = Questions::with(['questionoptions.options'])
        ->where('section_id', $section_id)
        ->where('up_question_id',0)
        ->orderBy('question_order')
        ->get();

        return response()->json(QuestionsResource::collection($questions),200);

        //return response()->json($questions,200);

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($section_id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$section_id)
    {
        //

        $arr = json_decode($request->questions, true);
        // print_r($arr);
          $arr2=[];
          $i=0;
          foreach ($arr as $b) {
              //assign child-array to newly create array variable
              $arr2[] =  ['question_id'=>$b['question_id'],'question_order'=>$i];  
              $i++;
          }
          $userInstance = new Questions;
          $index = 'question_id';
  
         batch()->update($userInstance, $arr2, $index);
  
         return $arr2;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($question_id)
    {
        //question id gelecek 
        //subquestionsları göster
        

        $questions = Questions::with(['questionoptions.options'])
        //->where('section_id', $section_id)
        ->where('up_question_id',$question_id)
        ->orderBy('question_order')
        ->get();

        return response()->json(QuestionsResource::collection($questions),200);

        
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
    public function update(Request $request, $question_id)
    {
        //soruyu update et
        $question = Questions::find($question_id);
        $question->question = $request->question;
        $question->answer_type_id = $request->answer_type;
        $question->save();

        QuestionOptions::where('question_id',$question_id)->delete();

        if ( $request->answer_type=="1"){

            $arr = json_decode($request->options, true);


            if( $request->yanit_seti=="true"){

           

                    $arr2=[];
                    $arr3=[];

                    $sets=new OptionSets();
                    $sets->save();  

                    foreach($arr as $data)
                    {
                        $id = Options::insertGetId($data);
                        $arr2[] =  ['option_id'=>$id,'set_id'=>$sets->set_id];  
                        $arr3[] =  ['option_id'=>$id,'question_id'=>$question->question_id]; 
                    
                    
                    }

                    DB::table('option_has_sets')->insert($arr2);
                    DB::table('question_has_options')->insert($arr3);
                    
            }

            else
            {  

                      // print_r($arr);
                      $arr2=[];

                      foreach ($arr as $b) {
                          //assign child-array to newly create array variable
                         // if((int)$b['option_id']!=0){
                         // $arr2[] =  ['option_id'=>$b['option_id'],'question_id'=>$question->question_id]; 
                          //}
                          //else{
                          //optionu ekle 
                          $option = new Options();
                          $option->option_name=$b['option_name'];
                          $option->score=$b['score'];
                          $option->save();
                          $arr2[] =  ['option_id'=>$option->option_id,'question_id'=>$question->question_id]; 
                          //}
                      }
  
                      DB::table('question_has_options')->insert($arr2);

            }

        }

        $questions = Questions::with(['questionoptions.options'])
        ->where('question_id', $question_id)
        ->get();

        return response()->json(QuestionsResource::collection($questions),200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     * 
     */



    public function find_sub_questions($question_id){
        $sub_questions=Questions::where('up_question_id',$question_id)->get();
      
        if($sub_questions){
        foreach ($sub_questions as $q){
                    QuestionOptions::where('question_id',$q->question_id)->delete();
                    Questions::find($q->question_id)->delete();
                    $this->find_sub_questions($q->question_id);
        }}

    } 

    public function destroy($question_id)
    {
        $this->find_sub_questions($question_id);
     
        //
        QuestionOptions::where('question_id',$question_id)->delete();
        //delete all sub questions 
        Questions::destroy($question_id);
       
        
        return response()->json(['question_id'=>$question_id],200);
    }

    public function question_order($section_id,$up_question_id){
        //section id ye göre maks question orderi alır 
        $question_order=Questions::where('section_id', $section_id)->where('up_question_id',$up_question_id)->max('question_order');
        if($question_order || $question_order==0){
            $question_order=$question_order+1;
            return $question_order;
        }
        else{
            return 0;
        }
    }

    public function addQuestion(Request $request){
        //soruyu ekle 
       
        $question = new Questions();
        $question->question = $request->question;
        $order = $this->question_order((int)$request->section_id,(int)$request->up_question_id);
        $question->question_order=(int)$order;
        $question->is_required = $request->is_required;
        $question->answer_type_id = $request->answer_type;
        $question->up_question_id = $request->up_question_id;
        $question->section_id = $request->section_id;
        $question->save();
            
        //answer type check box ise 
        if ( $request->answer_type=="1"){

            $arr = json_decode($request->options, true);
            
            if( $request->yanit_seti=="true"){


                    $arr2=[];
                    $arr3=[];

                    $sets=new OptionSets();
                    $sets->save();  

                    foreach($arr as $data)
                    {
                        $id = Options::insertGetId($data);
                        $arr2[] =  ['option_id'=>$id,'set_id'=>$sets->set_id];  
                        $arr3[] =  ['option_id'=>$id,'question_id'=>$question->question_id]; 
                    
                    
                    }

                    DB::table('option_has_sets')->insert($arr2);
                    DB::table('question_has_options')->insert($arr3);
                    
            }
            else
            {           

                    // print_r($arr);
                    $arr2=[];

                    foreach ($arr as $b) {
                        //assign child-array to newly create array variable
                       // if((int)$b['option_id']!=0){
                       // $arr2[] =  ['option_id'=>$b['option_id'],'question_id'=>$question->question_id]; 
                        //}
                        //else{
                        //optionu ekle 
                        $option = new Options();
                        $option->option_name=$b['option_name'];
                        $option->score=$b['score'];
                        $option->save();
                        $arr2[] =  ['option_id'=>$option->option_id,'question_id'=>$question->question_id]; 
                        //}
                    }

                    DB::table('question_has_options')->insert($arr2);

            }
        }
        
        //hazır yanıt seti seçilmiş ise optionslar ile soru id yi direkt ekle 
        //yanıt seti ekle der ise yanıt seti tablosuna bir kayıt aç 
        //id yi al 
        //option_has_sets tablosuna kaydet
        //option id ler ile question id yi kaydet
        //optionları ile beraber geri dödnür 
        $questions = Questions::with(['questionoptions.options'])
        ->where('question_id', $question->question_id)
        ->get();

        return response()->json(QuestionsResource::collection($questions),200);
    }
}
