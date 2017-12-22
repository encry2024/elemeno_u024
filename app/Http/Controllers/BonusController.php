<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Bonus;
use App\Employee;

use App\Http\Requests\StoreBonusRequest;
use App\Http\Requests\UpdateBonusRequest;

class BonusController extends Controller
{
    public function index(){
    	if(! Gate::allows('bonus_access')){
    		return response()->view('errors.401', [], 401);
    	}

    	$bonuses = Bonus::with('employee')->orderBy('date', 'desc')->get();

    	return view('admin.bonus.index', compact('bonuses'));
    }

    public function create(){
    	if(! Gate::allows('bonus_create')){
    		return response()->view('errors.401', [], 401);
    	}

    	$employees = Employee::selectRaw("CONCAT(fname,' ',lname) as fullname, id")->pluck('fullname','id')->prepend('Please select', '');

    	return view('admin.bonus.create', compact('employees'));
    }

    public function store(StoreBonusRequest $request){
    	if(! Gate::allows('bonus_create')){
    		return response()->view('errors.401', [], 401);
    	}

		$type = $request->type == 'Others' ? $request->others : $request->type;
		$request['type'] 			= $type;

    	$bonus = Bonus::create($request->all());

    	return redirect()->route('admin.bonus.index');
    }

    public function edit($id){
		if(! Gate::allows('bonus_edit')){
			return response()->view('errors.401', [], 401);
		}

		$bonus = Bonus::findOrFail($id);

		return view('admin.bonus.edit', compact('bonus'));
	}

	public function update(UpdateBonusRequest $request, $id){
		if(! Gate::allows('bonus_edit')){
			return response()->view('errors.401', [], 401);
		}

		$bonus = Bonus::findOrFail($id);
		$bonus->update($request->all());

		return redirect()->route('admin.bonus.index');
	}

	public function show($id){
		if(! Gate::allows('bonus_view')){
			return response()->view('errors.401', [], 401);
		}

		$bonus = Bonus::findOrFail($id);

		return view('admin.bonus.show', compact('bonus'));
	}

    public function destroy($id){
        if(! Gate::allows('bonus_delete')){
            return response()->view('errors.401', [], 401);
        }

        $bonus = Bonus::findOrFail($id);
        $bonus->delete();

        return redirect()->route('admin.bonus.index');
    }
}
