<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Log;

class LogController extends Controller
{
    public function index(){
        if(! Gate::allows('log_access')){
            return response()->view('errors.401', [], 401);
        }

        $logs = Log::all();

        return view('admin.logs.index', compact('logs'));
    }
}
