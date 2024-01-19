<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
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

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
    
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guide', // Définir le rôle comme "guide"
        ]);

        return response()->json([
            'message' => 'Guide créé avec succès',
            'user' => $user,
        ]);
    }

    public function listerGuides()
    {
        $guides = User::where('role', 'guide')->get();
        return response()->json($guides);
    }


    public function deleteGuide($userId)
    {
        // Vérifier si l'utilisateur authentifié a le rôle d'administrateur
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Vous n\'avez pas les autorisations nécessaires pour supprimer un guide.'], 403);
        }

        // Vérifier si l'utilisateur avec l'ID spécifié existe et a le rôle de guide
        $guide = User::where('id', $userId)->where('role', 'guide')->first();

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

   // $user->update();

    return response()->json(['message' => 'Profil mis à jour avec succès', 'user' => $user]);
}
}
