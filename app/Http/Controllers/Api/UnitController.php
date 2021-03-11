<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{


    public function index(Request $request)
    {
        $units = new Unit();

        if ($request->has('query')) {
            $query = $request->get('query');
            $units = $units->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%$query%")->orWhere('description', 'LIKE', "%$query%");
            });
        }

        $units = $units->paginate(50);

        return response()->json($units);
    }

    public function edit(Unit $unit)
    {
        if (!$unit) {
            return response()->json("operation failed", 404);
        }
        return response()->json($unit, 200);
    }

    public function update(Unit $unit, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:units,name,' . $unit->id
        ]);

        if ($unit) {
            $unit->name = $request->get('name');
            $unit->description = $request->get('description');
            $unit->save();
            return response()->json($unit);
        }

        return response()->json([
            'message' => 'The unit is not available.'
        ], 404);
    }
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:units,name'
        ]);

        $unit = new Unit();

        $unit->name = $request->get('name');
        $unit->description = $request->get('description');
        $unit->user_id = Auth::user()->id;
        // $unit->company_id = Auth::user()->company_id;
        $unit->save();

        return response()->json($unit);

        return response()->json([
            'message' => 'Cannot create unit'
        ], 404);
    }
    public function destroy(Unit $unit)
    {
        if ($unit) {
            $unit->delete();
        }

        return response()->json([
            'message' => 'The unit removed successfully!'
        ]);
    }
}
