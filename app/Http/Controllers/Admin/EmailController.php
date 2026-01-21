<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ResendMailService;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    protected $resendService;

    public function __construct(ResendMailService $resendService)
    {
        $this->resendService = $resendService;
    }

    /**
     * Show the email composition form
     */
    public function create(Request $request)
    {
        $patients = User::where('role', 'patient')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $selectedPatient = null;
        if ($patientId = $request->input('patient_id')) {
            $selectedPatient = User::find($patientId);
        }

        return view('admin.emails.create', compact('patients', 'selectedPatient'));
    }

    /**
     * Send the email
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => ['required', 'exists:users,id'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        $patient = User::findOrFail($validated['patient_id']);

        // Create HTML email from template
        $html = view('emails.custom-message', [
            'user' => $patient,
            'subject' => $validated['subject'],
            'messageContent' => $validated['message'],
        ])->render();

        $result = $this->resendService->send([
            'to' => [$patient->email],
            'subject' => $validated['subject'],
            'html' => $html,
        ]);

        if ($result) {
            return redirect()->route('admin.emails.create')
                ->with('success', "Email berhasil dikirim ke {$patient->name} ({$patient->email})!");
        } else {
            return back()
                ->withInput()
                ->with('error', 'Gagal mengirim email. Silakan coba lagi.');
        }
    }
}
