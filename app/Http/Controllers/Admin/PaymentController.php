<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Payment;
use App\Models\Enrollment; 
use App\Models\Plan; 
use Illuminate\Support\Facades\DB; 

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with([
            'enrollment.studentProfile.user', 
            'enrollment.category', 
            'enrollment.plan', 
        ])
        ->orderByDesc('paid_at')
        ->paginate(5); 

        $enrollments = Enrollment::where('status', 'active')
            ->with(['studentProfile.user', 'category', 'plan']) 
            ->get()
            ->sortBy(fn($enrollment) => $enrollment->studentProfile->user->name ?? 'Z')
            ->values();

        return view('admin.payments.index', compact('payments', 'enrollments'));
    }

    public function create()
    {
        return redirect()->route('admin.payments.index');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|string|in:cash,transfer,card,online,yape',
            'paid_at' => 'required|date',
        ]);

        $enrollment = Enrollment::findOrFail($validatedData['enrollment_id']);
        
        Payment::create([
            'enrollment_id' => $validatedData['enrollment_id'],
            'plan_id' => $enrollment->plan_id,
            'amount' => $validatedData['amount'],
            'method' => $validatedData['method'],
            'paid_at' => $validatedData['paid_at'],
            'status' => 'paid',
        ]);

        return redirect()->route('admin.payments.index')->with('success', 'Pago registrado exitosamente. Si fue una renovación, recuerde actualizar la membresía.');
    }

    public function show(Payment $payment)
    {
        $payment->load([
            'enrollment.studentProfile.user', 
            'enrollment.category', 
            'enrollment.plan' 
        ]);
        
        return view('admin.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $payment->load(['enrollment.studentProfile.user', 'enrollment.plan']);

        $enrollments = Enrollment::where('status', 'active')
            ->with(['studentProfile.user', 'category', 'plan'])
            ->get();
        
        return view('admin.payments.edit', compact('payment', 'enrollments'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validatedData = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|string|in:cash,transfer,card,online,yape', 
            'paid_at' => 'nullable|date', 
            'status' => ['required', 'string', Rule::in(['paid', 'pending', 'expired', 'cancelled'])], 
            'details' => 'nullable|string|max:500', 
        ]);

        if ($payment->enrollment_id != $validatedData['enrollment_id']) {
            $enrollment = Enrollment::findOrFail($validatedData['enrollment_id']);
            $validatedData['plan_id'] = $enrollment->plan_id; 
        }

        $payment->update($validatedData);

        return redirect()->route('admin.payments.show', $payment)->with('success', 'Pago actualizado correctamente.');
    }

    public function destroy(Payment $payment)
    {
        if ($payment->status === 'paid' || $payment->status === 'pending') {
            
            $payment->update([
                'status' => 'cancelled', 
            ]);

            return redirect()->route('admin.payments.index')->with('success', "El pago #{$payment->id} ha sido anulado.");
        }
        
        return redirect()->route('admin.payments.index')->with('error', "El pago #{$payment->id} ya se encuentra en estado '{$payment->status}' y no puede ser anulado.");
    }
}