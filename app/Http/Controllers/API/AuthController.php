<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Guide;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register','login_guide']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);
        
        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }


    public function login_guide(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = Auth::guard('apiguide')->attempt($credentials);
        
        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $guide = Auth::guard('apiguide')->user();
        return response()->json([
            'guide' => $guide,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }



    public function register(Request $request)
    {
       // $request->validate([
       $validator=Validator::make($request->all(),[

            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ],422);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role ?? 'visiteur', // Si le rôle n'est pas fourni, utilisez "visiteur" par défaut
            'password' => Hash::make($request->password),
        ]);
    
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }
    

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function createGuide(Request $request)
    {
       $validator=Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:guides,email',
            'password' => 'required|string|min:6',
            'description'=> 'required|string',
            'duree_experience' => 'required|string',
            'zone_id' => 'required|exists:zone_touristiques,id',
            'image' => 'sometimes'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ],422);
        }
        $imageName=null;
        if($request->hasFile('image')){
            $imageName=$request->file('image')->store('image', 'public');
             }
        $user = Guide::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'description' => $request->description,
            'duree_experience' => $request->duree_experience,
            'zone_id' => $request->zone_id,
            'image'=> $imageName

        ]);

        return response()->json([
            'message' => 'Guide créé avec succès',
            'guide' => $user,
        ]);
    }


    public function deleteGuide($guideId)
    {
        // Vérifier si l'utilisateur authentifié a le rôle d'administrateur
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Vous n\'avez pas les autorisations nécessaires pour supprimer un guide.'], 403);
        }

        // Vérifier si l'utilisateur avec l'ID spécifié existe 
        $guide = Guide::where('id', $guideId)->first();

        if (!$guide) {
            return response()->json(['message' => 'Guide non trouvé.'], 404);
        }

        // Supprimer le guide
        $guide->delete();

        return response()->json(['message' => 'Guide supprimé avec succès']);
    }

    public function updateProfile(Request $request)
{
    // Récupérer l'utilisateur authentifié
    $user = auth()->user();
   
    // Validation des données
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'password' => 'nullable|string|min:6',
    ]);

    // Mise à jour des informations de l'utilisateur
    $user->name = $request->name;
    $user->email = $request->email;
  
    // Vérifier et mettre à jour le mot de passe s'il est fourni
    if ($request->has('password')) {
        $user->password = bcrypt($request->password);
    }
    // Enregistrer les modifications dans la base de données

    //$user->update();

    return response()->json(['message' => 'Profil mis à jour avec succès', 'user' => $user]);
}

}
