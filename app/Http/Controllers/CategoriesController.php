<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\items;
class CategoriesController extends Controller
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
        $category = new Categories;
        $category->name = strip_tags($request->category_name);
       
        $category->save();

        if (auth()->user()->hasRole('admin')) {
            //Direct to that page directly
            return redirect()->route('items.index')->withStatus(__('Category successfully created.'));
        }

        return redirect()->route('items.index')->withStatus(__('Category successfully created.'));
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
    public function update(Request $request, Categories $category)
    {
        $category->name = $request->category_name;
        $category->update();

        return redirect()->back()->withStatus(__('Category name successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categories $category)
    {
        /*foreach($category->items as $item){
            $item->delete();
        }*/
        //$category->active = 0;
        //$category->save();
        $category->delete();
        //Delete items
        //Delete extras
        //Delete Options
        //Deletee Options

        return redirect()->route('items.index')->withStatus(__('Category successfully deleted.'));
    }
}
