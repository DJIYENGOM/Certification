<?php
namespace App\Http\Controllers;

use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
    public function ajouterCommentaire(Request $request, $zoneId)
    {
        $request->validate([
            'contenu' => 'required|string',
        ]);

        $commentaire = new Commentaire([
            'contenu' => $request->input('contenu'),
            'user_id' => Auth::id(),
            'zone_id' => $zoneId,
        ]);

        $commentaire->save();

        return response()->json(['message' => 'Commentaire ajouté avec succès']);
    }

    public function supprimerCommentaire($commentaireId)
    {
        $commentaire = Commentaire::findOrFail($commentaireId);

        // Vérifiez si l'utilisateur est autorisé à supprimer le commentaire (peut être un admin)
        $this->authorize('delete', $commentaire);

        $commentaire->delete();

        return response()->json(['message' => 'Commentaire supprimé avec succès']);
    }

    public function listerCommentaires($zoneId)
    {
        $commentaires = Commentaire::where('zone_id', $zoneId)->get();
        return response()->json($commentaires);
    }

    public function compterCommentaires($zoneId)
    {
        $nombreCommentaires = Commentaire::where('zone_id', $zoneId)->count();
        return response()->json(['nombre_commentaires' => $nombreCommentaires]);
    }
}