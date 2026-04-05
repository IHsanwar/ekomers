<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class ComplaintController extends Controller
{
    public function create(Transaction $transaction)
    {
        if ($transaction->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }
        
        if ($transaction->status !== 'completed' || $transaction->complaint) {
            return redirect()->back()->with('error', 'Transaksi ini tidak valid untuk komplain.');
        }

        return view('frontend.complaints.create', compact('transaction'));
    }

    public function store(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        if ($transaction->status !== 'completed' || $transaction->complaint) {
            return redirect()->back()->with('error', 'Transaksi ini tidak valid untuk komplain.');
        }

        $validated = $request->validate([
            'reason_category' => 'required|string',
            'action_type' => 'required|in:refund,replacement',
            'description' => 'required|string',
            'refund_method' => 'required_if:action_type,refund|nullable|string',
            'refund_account' => 'required_if:action_type,refund|nullable|string',
            'contact_number' => 'required|string',
            'evidence_image' => 'required|image|mimes:jpeg,png,jpg|max:5000',
        ]);

        $imagePath = null;
        if ($request->hasFile('evidence_image')) {
            $imagePath = $request->file('evidence_image')->store('complaints', 'public');
        }

        \App\Models\Complaint::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'transaction_id' => $transaction->id,
            'reason_category' => $validated['reason_category'],
            'description' => $validated['description'],
            'evidence_images' => $imagePath,
            'status' => 'pending',
            'action_type' => $validated['action_type'],
            'refund_method' => $validated['refund_method'] ?? null,
            'refund_account' => $validated['refund_account'] ?? null,
            'contact_number' => $validated['contact_number'],
        ]);
        
        $transaction->update(['status' => 'complained']);

        $complaintId = \App\Models\Complaint::where('transaction_id', $transaction->id)->first()->id;

        return redirect()->route('frontend.complaints.show', $complaintId)
                         ->with('success', 'Komplain berhasil diajukan.');
    }

    public function show(\App\Models\Complaint $complaint)
    {
        if ($complaint->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }
        
        $complaint->load('transaction.items.product');

        return view('frontend.complaints.show', compact('complaint'));
    }
}
