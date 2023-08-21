<?php

namespace App\Http\Controllers\Nova;

use Exception;
use App\Models\DNC;
use Laravel\Nova\Nova;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\User;

class NewBotController extends Controller
{
   public function new_bot(Request $request){



   	return response()->json([
            'data' => $request->all(),
        ], 200);
   }
}
