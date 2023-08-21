<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    public function index()
    {
        return view('admin.logs.index');
    }

    public function show($date)
    {
        $file_path = storage_path("logs/laravel-{$date}.log");
        if (File::exists($file_path)) {
            $file = File::get($file_path);

            return $file;
        }
        // else{
            return ;
        // }
        // dd($file_path);
    }
}
