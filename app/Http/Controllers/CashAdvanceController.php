<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\CashAdvance;
use App\Employee;

use App\Http\Requests\StoreCashRequest;
use App\Http\Requests\UpdateCashRequest;

class CashAdvanceController extends Controller
{
    
	public function index(){
		if(! Gate::allows('cash_advance_access')){
			return response()->view('errors.401', [], 401);
		}

		$relations = [
			'cash_advances' => CashAdvance::orderBy('created_at', 'desc')->get(),
		];

		return view('admin.cash_advance.index', $relations);
	}

	public function create(){
		if(! Gate::allows('cash_advance_create')){
			return response()->view('errors.401', [], 401);
		}

		$employee = Employee::selectRaw("CONCAT(fname,' ', lname) AS full_name, id")->pluck('full_name','id')->prepend('Please select', '');

		return view('admin.cash_advance.create', compact('employee'));
	}

	public function store(StoreCashRequest $request){
		if(! Gate::allows('cash_advance_create')){
			return response()->view('errors.401', [], 401);
		}

		$cash_advance = CashAdvance::create($request->all());

		return redirect()->route('admin.cash_advance.index');
	}

	public function show($id){
		if(! Gate::allows('cash_advance_view')){
			return response()->view('errors.401', [], 401);
		}

		$cash_advance = CashAdvance::findOrFail($id);

		return view('admin.cash_advance.show', compact('cash_advance'));
	}

	public function edit($id){
		if(! Gate::allows('cash_advance_edit')){
			return response()->view('errors.401', [], 401);
		}

		$cash_advance = CashAdvance::findOrFail($id);

		return view('admin.cash_advance.edit', compact('cash_advance'));
	}

	public function update(UpdateCashRequest $request, $id){
		if(! Gate::allows('cash_advance_edit')){
			return response()->view('errors.401', [], 401);
		}

		$cash_advance = CashAdvance::findOrFail($id);
		$cash_advance->update($request->all());

		return redirect()->route('admin.cash_advance.index');
	}

	public function destroy($id){
		if(! Gate::allows('cash_advance_delete')){
			return response()->view('errors.401', [], 401);
		}

		$cash_advance = CashAdvance::findOrFail($id);
		$cash_advance->delete();

		return redirect()->route('admin.cash_advance.index');
	}

	public function massDestroy(Request $request)
    {
        if (! Gate::allows('cash_advance_delete')) {
            return response()->view('errors.401', [], 401);
        }

        if($request->input('ids')) {
           $entries = CashAdvance::whereIn('id', $request->input('ids'))->get();
        }

        foreach ($entries as $entry) {
            $entry->delete();
        }
    }

}
