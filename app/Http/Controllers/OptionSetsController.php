<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OptionSets;
use Illuminate\Support\Facades\DB;

class OptionSetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //option setleri getir
        //SELECT c.set_id,GROUP_CONCAT(c.option_name) FROM 
        //(Select option_name,set_id from option_has_sets as b left join options as opt on opt.option_id=b.option_id)
        // as c GROUP BY c.set_id;

        $sql=DB::table('option_has_sets as b')
         ->selectRaw('option_name,set_id')
         ->leftJoin('options as opt', 'opt.option_id', '=', 'b.option_id');


        $optionsets = DB::table(DB::raw('('. $sql->toSql() . ') AS c'))
        ->selectRaw('c.set_id,GROUP_CONCAT(c.option_name) as options')
        ->groupBy('c.set_id')
        ->get();

        return response()->json($optionsets,200);

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
