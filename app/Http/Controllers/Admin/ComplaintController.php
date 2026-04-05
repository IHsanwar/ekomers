<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Complaint;
use App\Models\Transaction;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with('transaction', 'user')->latest()->get();
        return view('admin.complaints.index', compact('complaints'));
    }

    public function show(Complaint $complaint)
    {
        $complaint->load('transaction.items.product', 'user');
        return view('admin.complaints.show', compact('complaint'));
    }

    public function action(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected,resolved',
            'admin_notes' => 'nullable|string'
        ]);

        $complaint->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'],
        ]);

        if ($validated['status'] === 'approved') {
            if ($complaint->action_type === 'refund') {
                $complaint->transaction->update(['status' => 'refunded']);
            } else {
                $complaint->transaction->update(['status' => 'returning']);
            }
        } elseif ($validated['status'] === 'rejected') {
            $complaint->transaction->update(['status' => 'completed']);
        }

        return redirect()->route('admin.complaints.index')->with('success', 'Status komplain berhasil diperbarui.');
    }
}
