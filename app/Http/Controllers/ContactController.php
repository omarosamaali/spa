<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $request->merge([
            'email' => $request->filled('email') ? trim($request->input('email')) : null,
        ]);

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'email'   => 'nullable|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ], [
            'name.required'    => 'الاسم مطلوب',
            'name.max'         => 'الاسم طويل جداً',
            'phone.required'   => 'رقم الهاتف مطلوب',
            'phone.max'        => 'رقم الهاتف غير صحيح',
            'email.email'      => 'البريد الإلكتروني غير صحيح',
            'subject.required' => 'الموضوع مطلوب',
            'message.required' => 'نص الرسالة مطلوب',
            'message.max'      => 'الرسالة طويلة جداً (الحد الأقصى 2000 حرف)',
        ]);

        ContactMessage::create($validated);

        return redirect()->route('contact')
            ->with('success', 'تم إرسال رسالتك بنجاح! سنتواصل معك في أقرب وقت.');
    }
}
