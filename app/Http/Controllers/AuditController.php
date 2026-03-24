<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user')->orderBy('created_at', 'desc');

        if ($request->search) {
            $query->where('action', 'like', '%'.$request->search.'%')
                  ->orWhere('model_type', 'like', '%'.$request->search.'%');
        }
        if ($request->action) {
            $query->where('action', $request->action);
        }
        if ($request->date_debut) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        if ($request->date_fin) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }

        $logs = $query->paginate(20);
        return view('audit.index', compact('logs'));
    }

    public function show(AuditLog $log)
    {
        $log->load('user');
        return view('audit.show', compact('log'));
    }
}