<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string',
            'message' => 'required|string|min:10',
        ]);
        
        // Envoyer email ou sauvegarder en base
        Mail::to('contact@tpi-sidibennour.ma')->send(new ContactMail($validated));
        
        return redirect()->route('contact')->with('success', 'Votre message a été envoyé avec succès.');
    }
}