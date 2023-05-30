<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    // register function for support agents

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|max:255',
        ]);

        try {
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'user' => $user,
                'token' => $user->createToken('token')->plainTextToken,
                'message' => 'Registered successfully'
            ], 201);
        } catch (\Exception $e) {
            // Return the exception message as error message
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

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

    // get all tickets function

    public function getTickets()
    {
        $all_tickets = SupportTicket::get(['id', 'customer_name', 'problem_description', 'email', 'phone_number', 'reference_number', 'is_open']);
        return $all_tickets;
    }
}
