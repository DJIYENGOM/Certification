<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

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

}
