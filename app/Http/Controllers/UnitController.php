<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    private static $unit,$units;

    public function index()
    {
        return view('admin.unit.index');
    }
    public function store()
    {
        self::$units = Unit::all();
        return view('admin.unit.manage', [
            'units' => self::$units
        ]);
    }
    public function create(Request $request)
    {
        Unit::newUnit($request);
        return back()->with('message', 'Unit Info Create successfully');
    }
    public function destroy(Request $request)
    {
        Unit::destroy($request->id);
        return back()->with('message', ' Unit Info deleted');
    }
    public function edit($id)
    {
        self::$unit = Unit::find($id);
        return view('admin.unit.edit', [
            'unit' => self::$unit
        ]);
    }
    public function updates(Request $request)
    {
        Unit::updates($request);
        return back()->with('message', 'Unit Info updated');
    }
}
