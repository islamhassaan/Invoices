<?php

namespace App\Http\Controllers;

use App\sctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SctionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = sctions::all();
        return view("sections.sections", compact("sections"));
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
        $validatedData = $request->validate([
            'section_name' => 'required|unique:sctions|max:255',
            'description' => 'required',
        ],[

            'section_name.required' =>'يرجي ادخال اسم القسم',
            'section_name.unique' =>'اسم القسم مسجل مسبقا',
            'description.unique' =>'يرجي إدحال البيان',


        ]);

        Sctions::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'Created_by' => (Auth::user()->name),

        ]);
        session()->flash('Add', 'تم اضافة القسم بنجاح ');
        return redirect('/sections');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\sctions  $sctions
     * @return \Illuminate\Http\Response
     */
    public function show(sctions $sctions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\sctions  $sctions
     * @return \Illuminate\Http\Response
     */
    public function edit(sctions $sctions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sctions  $sctions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;

        $this->validate($request, [

            'section_name' => 'required|max:255|unique:sctions,section_name,'.$id,
            'description' => 'required',
        ],[

            'section_name.required' =>'يرجي ادخال اسم القسم',
            'section_name.unique' =>'اسم القسم مسجل مسبقا',
            'description.required' =>'يرجي ادخال البيان',

        ]);

        $sections = Sctions::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);

        session()->flash('edit','تم تعديل القسم بنجاج');
        return redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sctions  $sctions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        sctions::find($id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('/sections');
    }
}
