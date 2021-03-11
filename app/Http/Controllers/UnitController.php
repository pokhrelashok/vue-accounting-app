<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Unit::where('company_id', 1)->paginate(50);
        return view('pages.units.index', compact('units'));
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
        $this->validate($request, [
            'name' => 'required|unique:units'
        ]);

        $unit = new Unit();

        $unit->name = $request->get('name');
        // $unit->company_id = 1;
        $unit->user_id = Auth::user()->id;
        $unit->description = $request->get('description') ?? null;

        $unit->save();

        return redirect()->back()->with('success', 'Unit added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        if (!$unit) {
            return redirect()->back()->with('warning', 'The unit you wanted to edit does not exist.');
        }

        return view('pages.units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit)
    {

        if (!$unit) {
            return redirect()->back()->with('warning', 'The unit you wanted to edit does not exist.');
        }

        $this->validate($request, [
            'name' => 'required|unique:units,name,' . $unit->id
        ]);

        $unit->name = $request->get('name');
        $unit->description = $request->get('description') ?? null;
        $unit->save();

        return redirect()->action('UnitController@index')->with('success', 'Unit updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        if ($unit) {
            $unit->delete();
        }

        return redirect()->action('UnitController@index')->with('success', 'Unit deleted successfully!');
    }
}
