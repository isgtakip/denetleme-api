<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customers;

class CustomerController extends Controller
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
        $per_page = $request->query('per_page');

        return response()->json(Customers::where(function($query) use ($search) {
            $query->where('customers.customer_name', 'like', '%'.$search.'%')
            ->orWhere('customers.customer_domain', 'like', '%'.$search.'%');
        })
        ->paginate($per_page)->appends(request()->query()),200);
    }

    /**
     * Show the form for creating a new resodurce.
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
        //yeni kayıt eklemek için burayı kullanacaz 
        $customer = new Customers();
        $customer->customer_name = $request->customer_name;
        $customer->customer_domain = $request->customer_domain;


        $customer->save();
        
        //firma bilgileri geri döndürülecek daha sonra 
 
        return response()->json('Müşteri başarı ile eklendi',200);
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
        //put requesti buraya geliyor 
        $customer = Customers::find($id);
      
        $customer->customer_name = $request->customer_name;
        $customer->customer_domain = $request->customer_domain;
     
        $customer->update();
        
        //firma bilgileri geri döndürülecek daha sonra 
        return response()->json("Firma Kaydı düzeltilmiştir", 200);
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
        Customers::destroy($id); 
        //firma id yi geri döndür
        return response()->json($id,200);
    }
}
