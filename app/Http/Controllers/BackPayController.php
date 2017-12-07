<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\BackPay;
use App\Employee;

class BackPayController extends Controller
{
    public function index(){
    	if(! Gate::allows('backpay_access')){
    		return response()->view('errors.401', [], 401);
    	}

    	$backpays = BackPay::with('employee')->orderBy('date','desc')->get();

    	return view('admin.backpay.index', compact('backpays'));
    }

    public function approve($id){
    	if(! Gate::allows('backpay_edit')){
    		return response()->view('errors.401', [], 401);
    	}

    	BackPay::where('id', $id)->update(['status' => 'Paid']);

    	return redirect()->route('admin.backpay.index');
    }

    public function deny(){
		if(! Gate::allows('backpay_edit')){
    		return response()->view('errors.401', [], 401);
    	}

    	BackPay::where('id', $id)->update(['status' => 'Pending']);

    	return redirect()->route('admin.backpay.index');
    }
}
