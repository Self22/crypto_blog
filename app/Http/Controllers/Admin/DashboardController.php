<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
//        $user = Auth::user();
//
//        if (Gate::allows('is-admin', $user)) {
            return view('admin.index');
//        }
//
//        else {
//            echo 'У Вас нет прав доступа к этому разделу';
//            Auth::logout();
//
//        }

    }
}
