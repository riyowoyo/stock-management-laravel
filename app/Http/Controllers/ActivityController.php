<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'product'); // default audit produk

        if ($type === 'transaction') {
            $logs = Activity::where('log_name', 'transaction_audit')->latest()->paginate(10);
        } else {
            $logs = Activity::where('log_name', 'product_audit')->latest()->paginate(10);
        }

        return view('activities.index', compact('logs', 'type'));
    }
}
