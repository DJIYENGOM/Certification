<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Mail\Message as MailMessage;
use App\Mail\Response;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{



    public function EnvoieMessage(Request $request)
    {
       
       $validator=Validator::make($request->all(),[

            'nom' => 'required|string|max:255',
            'telephone' => 'required|string|max:12',
            'email' => 'required|string|email',
            'contenu' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ],422);
        }
        $message = new Message([
            'nom' => $request->input('nom'),
            'telephone' => $request->input('telephone'),
            'email' => $request->input('email'),
            'contenu' => $request->input('contenu'),

        ]);

        $message->save();
        $users=User::where('role','admin')->get();
        foreach($users as $user){
            Mail::to($user->email)->send(new MailMessage($message->nom, $message->contenu, $message->email, $message->telephone)); 
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


    public function response(Request $request)
    {
        try {
            $data = $request->contenu;
            if (Mail::to($request->email)->send(new Response($data))) {
                return response()->json(['message' => 'reponse envoye avec success']);
            } else {
                return response()->json(['message' => 'reponse non envoyer']);
            }
        } catch (\Throwable $th) {
            return  $th->getMessage();
        }
    }
}
