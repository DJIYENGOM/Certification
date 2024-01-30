<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Mail\Message as MailMessage;
use App\Models\User;

class MessageController extends Controller
{



    public function EnvoieMessage(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'required|string|email',
            'contenu' => 'required|string',
        ]);

        $message = new Message([
            'nom' => $request->input('nom'),
            'telephone' => $request->input('telephone'),
            'email' => $request->input('email'),
            'contenu' => $request->input('contenu'),

        ]);

        $message->save();
        $users=User::where('role','admin')->get();
        foreach($users as $user){
            Mail::to($user->email)->send(new MailMessage($message->nom, $message->contenu)); 
        }


        return response()->json(['message' => 'message ajouté avec succès']);
    }
    /**
     * Display a listing of the resource.
     */
    public function listerMessage()
    {
        $Message = Message::all();
        return response()->json($Message);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMessageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
