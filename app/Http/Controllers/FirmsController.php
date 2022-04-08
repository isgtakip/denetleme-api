<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FirmsModel;
use App\Models\FirmaTipleri;

class FirmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $search = $request->query('search');
        $firma_tur = $request->query('firma_tur');
        $per_page = $request->query('per_page');
        $ust_firma_id = $request->query('ust_firma_id');

        if ($ust_firma_id==0){
                $query= FirmsModel::whereRaw('1 = 1');
        }
        else{
                $query= FirmsModel::withoutGlobalScopes();
        }
        $query->where('firms.firma_turu', $firma_tur);
        $query->where('ust_firma_id',$ust_firma_id);
        $query->where(function($query) use ($search) {
            $query->where('firms.firma_tam_unvan', 'like', '%'.$search.'%')
            ->orWhere('firma_kisa_ad', 'like', '%'.$search.'%');
        });
        $query->leftJoin('nace_kodlari as nace', 'nace.nace_kod_id', '=', 'firms.nace_kod_id');
        
        return response()->json($query->paginate($per_page)->appends(request()->query()),200);
    }

    public function getAnaFirmalar(){
        return response()->json(FirmsModel::where('ust_firma_id',0)->get(),200);
    }


    public function formsData(Request $request){
        $firma_tipleri = FirmaTipleri::get();
        return response()->json($firma_tipleri,200);
    }

    public function getFirmsAllData(){
        return response()->json(FirmsModel::get(),200);
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

        $search="";
        //yeni kayıt eklemek için burayı kullanacaz 
        $firma = new FirmsModel();
        $firma->firma_tam_unvan = $request->firma_unvan;
        $firma->firma_tip_id = $request->firma_tip_id;
        $firma->firma_kisa_ad = $request->firma_kisa_ad;
        $firma->ust_firma_id= $request->ust_firma_id;
        $firma->firma_turu=$request->firma_turu;
        $firma->sahis_ad_soyad=$request->sahis_ad_soyad;
        $firma->nace_kod_id=$request->nace_kod_id;
        $firma->firma_sgk=$request->firma_sgk;
        $firma->firma_il_id=$request->firma_il_id;
        $firma->firma_ilce_id=$request->firma_ilce_id;


        $firma->save();
        
        //firma bilgileri geri döndürülecek daha sonra 
 
        return response()->json('Firma Başarı ile eklendi',200);
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
        
        $product = FirmsModel::find($firma_id);
        return response()->json($product);
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

         
         //put requesti buraya geliyor 
         $firma = FirmsModel::withoutGlobalScopes()->find($id);
       
         $firma->firma_tam_unvan = $request->firma_unvan;
         $firma->firma_tip_id = $request->firma_tip_id;
         $firma->firma_kisa_ad = $request->firma_kisa_ad;
         $firma->ust_firma_id= $request->ust_firma_id;
         $firma->firma_turu=$request->firma_turu;
         $firma->sahis_ad_soyad=$request->sahis_ad_soyad;
         $firma->nace_kod_id=$request->nace_kod_id;
         $firma->firma_sgk=$request->firma_sgk;
         $firma->firma_il_id=$request->firma_il_id;
         $firma->firma_ilce_id=$request->firma_ilce_id;
         $firma->update();
         
         //firma bilgileri geri döndürülecek daha sonra 
         return response()->json("Firma Kaydı düzeltilmiştir", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($firma_id)
    {
        //

        FirmsModel::withoutGlobalScopes()->find($firma_id)->delete();
        //firma id yi geri döndür
        return response()->json($firma_id,200);
    }
}
