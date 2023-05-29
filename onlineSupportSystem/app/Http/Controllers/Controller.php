<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // add ticket function

    public function addTicket(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'problem_description' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
        ]);

        $referenceNumber = 'TS' . strtoupper(uniqid());

        $supportTicket = SupportTicket::create([
            'customer_name' => $request->input('customer_name'),
            'problem_description' => $request->input('problem_description'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'reference_number' => $referenceNumber,
        ]);

        $emailText = "Hello {$supportTicket->customer_name},\n\n" .
            "Support ticket created succefully with the following details:\n" .
            "Reference Number: {$supportTicket->reference_number}\n" .
            "Problem Description: {$supportTicket->problem_description}\n" .
            "We will assist shortly.\n\n" .
            "Best Regards,\n" .
            "Support Team";

        Mail::raw($emailText, function ($message) use ($request) {
            $message->to($request->input('email'));
            $message->subject('Ticket Created');
        });

        return $supportTicket;
    }
}
