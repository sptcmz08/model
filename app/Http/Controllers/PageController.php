<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('about');
    }

    public function contact(): View
    {
        return view('contact');
    }

    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Send email to nattawut4085@gmail.com
        try {
            Mail::send([], [], function ($mail) use ($validated) {
                $mail->to('nattawut4085@gmail.com')
                    ->from($validated['email'], $validated['name'])
                    ->replyTo($validated['email'], $validated['name'])
                    ->subject('[tattooink12studio.com] Message from Contact: ' . $validated['subject'])
                    ->text("Message from Contact Form\n\nName: {$validated['name']}\nEmail: {$validated['email']}\nSubject: {$validated['subject']}\n\nMessage:\n{$validated['message']}");
            });

            return redirect()->route('contact')->with('success', 'Thank you for your message! We will get back to you soon.');
        } catch (\Exception $e) {
            return redirect()->route('contact')->with('error', 'Sorry, there was an error sending your message. Please try again later.');
        }
    }
}
