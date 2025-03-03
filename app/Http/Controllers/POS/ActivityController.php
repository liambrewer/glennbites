<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $stockMovements = StockMovement::orderBy('created_at', 'desc')->get();

        return view('pos.activity-stream', compact('stockMovements'));
    }
}
