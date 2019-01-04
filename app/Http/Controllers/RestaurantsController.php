<?php

namespace App\Http\Controllers;

use App\Restaurants;
use Illuminate\Http\Request;


class RestaurantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurants = Restaurants::all();

        return view('restaurants.index', compact('restaurants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('restaurants.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'rest_name'=>'required',
            'rest_address'=> 'required',
            'tel_num' => 'required|integer'
        ]);
        $restaurants = new Restaurants([
            'rest_name' => $request->get('rest_name'),
            'rest_address'=> $request->get('rest_address'),
            'tel_num'=> $request->get('tel_num')
        ]);
        $restaurants->save();
        return redirect('/restaurants')->with('success', 'Restaurant has been added');
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
        $restaurants = Restaurants::find($id);

        return view('restaurants.edit', compact('restaurants'));
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
        $request->validate([
            'rest_name'=>'required',
            'rest_address'=> 'required',
            'tel_num' => 'required|integer'
        ]);

        $restaurants = Restaurants::find($id);
        $restaurants->rest_name = $request->get('rest_name');
        $restaurants->rest_address = $request->get('rest_address');
        $restaurants->tel_num = $request->get('tel_num');
        $restaurants->save();

        return redirect('/restaurants')->with('success', 'Restaurant detail has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $restaurants = Restaurants::find($id);
        $restaurants->delete();

        return redirect('/restaurants')->with('success', 'Restaurant has been deleted Successfully');
    }
}
