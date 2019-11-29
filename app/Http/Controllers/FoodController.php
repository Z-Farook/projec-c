<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Food;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Food::all();
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $food = new Food();
        $food->productPic = ($request->input('productPic'));
        $food->product_name = ($request->input('product_name'));
        $food->product_price = ($request->input('product_price'));
        $food->save();
        if ($food)
            return response()->json($food, 200);
        else
            return response()->json("error");
    }


//
//productPic');
//product_name'
//product_price
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        //
        $food = Food:: find($id) ;

        $food->productPic = ($request->input('productPic'));
        $food->product_name = ($request->input('product_name'));
        $food->product_price = ($request->input('product_price'));
        $food->save();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // //
        // dd('sdasfd');
        // $request->product_name = ($request->input('product_name'));
        // $request->product_price = ($request->input('product_price'));
        // $request->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $food = Food::findOrFail($id);

        if ($food) {
            $food->delete();
            return response()->json(null, 204);
        } else {
            return response()->json("error");
        }
    }
}
