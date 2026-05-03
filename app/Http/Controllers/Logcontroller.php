<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function index()
    {
        $logs = DB::table('logs_sesiones')
            ->where('email', Auth::user()->email)
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get();

        return view('logs.index', compact('logs'));
    }
}