<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuiviCommandeController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('suivi_commandes')
            ->orderByRaw("feuille, date_demande IS NULL, date_demande");

        if ($request->search) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('nature',       'like', "%$s%")
                  ->orWhere('numero',     'like', "%$s%")
                  ->orWhere('fournisseur','like', "%$s%");
            });
        }

        if ($request->feuille)                  $query->where('feuille', $request->feuille);
        if ($request->type)                     $query->where('type',    $request->type);
        if ($request->livraison == 'ok')        $query->whereRaw("LOWER(livraison) = 'ok'");
        if ($request->livraison == 'en_cours')  $query->where('livraison', 'like', '%cours%');

        $suivi       = $query->paginate(20)->withQueryString();
        $total       = DB::table('suivi_commandes')->count();
        $livrees     = DB::table('suivi_commandes')->whereRaw("LOWER(livraison) = 'ok'")->count();
        $enCours     = DB::table('suivi_commandes')->where('livraison','like','%cours%')->count();
        $fournisseurs= DB::table('suivi_commandes')->whereNotNull('fournisseur')->distinct('fournisseur')->count();
        $countFeuil1 = DB::table('suivi_commandes')->where('feuille','Feuil1')->count();
        $countNamea  = DB::table('suivi_commandes')->where('feuille','DA Namaa')->count();

        return view('suivi.index', compact(
            'suivi','total','livrees','enCours',
            'fournisseurs','countFeuil1','countNamea'
        ));
    }
}