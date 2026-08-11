<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\NewContactMessage;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(ContactRequest $request)
    {
        $contactMessage = ContactMessage::create($request->only(['name', 'email', 'phone', 'subject', 'message']));

        $this->notifyGroupEmail($contactMessage);

        return redirect()
            ->route('contact')
            ->with('status', 'Thank you, your message has been sent. We will get back to you shortly.');
    }

    /**
     * Best-effort notification only: a down/misconfigured mail server must never
     * prevent the visitor's message from being saved, so failures are swallowed
     * and logged rather than surfaced.
     */
    private function notifyGroupEmail(ContactMessage $contactMessage): void
    {
        $groupEmail = Setting::get('group_email');

        if (! $groupEmail) {
            return;
        }

        try {
            Mail::to($groupEmail)->send(new NewContactMessage($contactMessage));
        } catch (Throwable $e) {
            report($e);
        }
    }
}
