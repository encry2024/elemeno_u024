<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Holiday;

use App\Http\Requests\StoreHolidayRequest;
use App\Http\Requests\UpdateHolidayRequest;

class HolidayController extends Controller
{
    public function index(){
    	if(! Gate::allows('holiday_access')){
    		return response()->view('errors.401', [], 401);
    	}

    	$holidays = Holiday::all();

    	return view('admin.holiday.index', compact('holidays'));
    }

    public function create(){
    	if(! Gate::allows('holiday_create')){
    		return response()->view('errors.401', [], 401);
    	}

    	return view('admin.holiday.create');
    }

    public function store(StoreHolidayRequest $request){
    	if(! Gate::allows('holiday_create')){
    		return response()->view('errors.401', [], 401);
    	}

	   	$holiday = Holiday::create($request->all());

    	return redirect()->route('admin.holiday.index');
    }

    public function edit($id){
    	if(! Gate::allows('holiday_edit')){
    		return response()->view('errors.401', [], 401);
    	}

    	$holiday = Holiday::findOrFail($id);

    	return view('admin.holiday.edit', compact('holiday'));
    }

    public function update(UpdateHolidayRequest $request, $id){
    	if(! Gate::allows('holiday_edit')){
    		return response()->view('errors.401', [], 401);
    	}

    	$holiday = Holiday::findOrFail($id);
    	$holiday->update($request->all());

    	return redirect()->route('admin.holiday.index');
    }

    public function destroy($id){
    	if(! Gate::allows('holiday_delete')){
    		return response()->view('errors.401', [], 401);
    	}

    	$holiday = Holiday::findOrFail($id);
    	$holiday->delete();

    	return redirect()->route('admin.holiday.index');
    }
}
