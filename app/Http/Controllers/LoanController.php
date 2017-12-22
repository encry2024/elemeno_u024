<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Employee;
use App\Loan;

use App\Http\Requests\StoreLoanRequest;
use Auth;

class LoanController extends Controller
{
    public function index(){
    	if(! Gate::allows('loan_access')){
    		return response()->view('errors.401', [], 401);
    	}

    	$loans = Loan::with('employee')->orderBy('date', 'desc')->get();

    	return view('employee.loan.index', compact('loans'));
    }

    public function create(){
    	if(! Gate::allows('loan_create')){
    		return response()->view('errors.401', [], 401);
    	}

		$employee = Employee::findOrFail(Auth::user()->employee->id);

    	return view('employee.loan.create', compact('employee'));
    }

    public function store(StoreloanRequest $request){
    	if(! Gate::allows('loan_create')){
    		return response()->view('errors.401', [], 401);
    	}

		$month = $request->months == 'Others' ? $request->others : $request->months;

		$request['months'] 			= $month;
		$request['monthly_payment']	= $request->amount / $month;
		$request['request_status']  = 'Pending';

    	$loan = loan::create($request->all());

    	return redirect()->route('employee.loan.index');
    }

    public function edit($id){
		if(! Gate::allows('loan_edit')){
			return response()->view('errors.401', [], 401);
		}

		$loan = loan::findOrFail($id);

		return view('employee.loan.edit', compact('loan'));
	}

	public function update(UpdateloanRequest $request, $id){
		if(! Gate::allows('loan_edit')){
			return response()->view('errors.401', [], 401);
		}

		$loan = loan::findOrFail($id);
		$loan->update($request->all());

		return redirect()->route('employee.loan.index');
	}

	public function show($id){
		if(! Gate::allows('loan_view')){
			return response()->view('errors.401', [], 401);
		}

		$loan = loan::findOrFail($id);

        $loan->with(['payments' => function($q) use($loan){
            $q->whereBetween('date', [$loan->date, date('Y-m-d')]);
        }])->get();
        
		return view('employee.loan.show', compact('loan'));
	}

	public function request(){
		if(! Gate::allows('loan_access')){
			return response()->view('errors.401', [], 401);
		}

		$loans = Loan::orderBy('date', 'desc')->get();

		return view('admin.loan.request', compact('loans'));
	}

	public function approve($id){
		if(! Gate::allows('loan_edit')){
			return response()->view('errors.401', [], 401);
		}

		$loan = Loan::findOrFail($id);
		$loan->request_status = 'Approved';
		$loan->save();

		return back();
	}

	public function deny($id){
		if(! Gate::allows('loan_edit')){
			return response()->view('errors.401', [], 401);
		}

		$loan = Loan::findOrFail($id);
		$loan->request_status = 'Denied';
		$loan->save();

		return back();
	}
}
