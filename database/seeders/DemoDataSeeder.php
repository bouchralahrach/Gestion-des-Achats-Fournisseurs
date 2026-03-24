<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Vider les tables d'abord
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('bons_reception')->truncate();
        DB::table('bons_commande')->truncate();
        DB::table('demandes_achats')->truncate();
        DB::table('fournisseurs')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // FOURNISSEURS
        DB::table('fournisseurs')->insert([
            ['code_fournisseur'=>'F-0001','raison_sociale'=>'ZIANELEC SARL','forme_juridique'=>'SARL','secteur_activite'=>'Électricité','ville'=>'Casablanca','pays'=>'Maroc','telephone'=>'0522345678','email'=>'contact@zianelec.ma','statut'=>'actif','is_deleted'=>false,'created_by'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['code_fournisseur'=>'F-0002','raison_sociale'=>'NAVARA BUREAU','forme_juridique'=>'SARL','secteur_activite'=>'Fournitures de bureau','ville'=>'Casablanca','pays'=>'Maroc','telephone'=>'0522456789','email'=>'contact@navara.ma','statut'=>'actif','is_deleted'=>false,'created_by'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['code_fournisseur'=>'F-0003','raison_sociale'=>'PRO-HYG','forme_juridique'=>'SARL','secteur_activite'=>'Hygiène','ville'=>'Casablanca','pays'=>'Maroc','telephone'=>'0522567890','email'=>'contact@prohyg.ma','statut'=>'actif','is_deleted'=>false,'created_by'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['code_fournisseur'=>'F-0004','raison_sociale'=>'MANAGEMENT CLEAN SERVICE','forme_juridique'=>'SA','secteur_activite'=>'Services','ville'=>'Rabat','pays'=>'Maroc','telephone'=>'0537123456','email'=>'contact@mcs.ma','statut'=>'actif','is_deleted'=>false,'created_by'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['code_fournisseur'=>'F-0005','raison_sociale'=>'Ste Spéciale Quincaillerie','forme_juridique'=>'SARL','secteur_activite'=>'Outillage','ville'=>'Casablanca','pays'=>'Maroc','telephone'=>'0522678901','email'=>'contact@ssq.ma','statut'=>'actif','is_deleted'=>false,'created_by'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['code_fournisseur'=>'F-0006','raison_sociale'=>'SAFETY AND SECURITY','forme_juridique'=>'SARL','secteur_activite'=>'Équipements de protection','ville'=>'Casablanca','pays'=>'Maroc','telephone'=>'0522789012','email'=>'contact@safety.ma','statut'=>'actif','is_deleted'=>false,'created_by'=>1,'created_at'=>now(),'updated_at'=>now()],
        ]);

        // DEMANDES D'ACHAT
	DB::table('demandes_achats')->insert([
    	['numero'=>'DA-2026-00001','objet'=>'Achat chaussures de sécurité','description'=>'10 paires pour agents terrain','quantite'=>10,'unite_mesure'=>'Unité','budget_estimatif'=>5000,'categorie'=>'EPI','centre_cout'=>'DRH','statut'=>'approuvee','demandeur_id'=>3,'validateur_id'=>4,'created_at'=>Carbon::now()->subDays(30),'updated_at'=>Carbon::now()->subDays(25)],
    	['numero'=>'DA-2026-00002','objet'=>'Fournitures de bureau','description'=>'Rames de papier A4 blanc et rose','quantite'=>50,'unite_mesure'=>'Rame','budget_estimatif'=>2500,'categorie'=>'Fournitures','centre_cout'=>'DAF','statut'=>'approuvee','demandeur_id'=>3,'validateur_id'=>4,'created_at'=>Carbon::now()->subDays(25),'updated_at'=>Carbon::now()->subDays(20)],
    	['numero'=>'DA-2026-00003','objet'=>'Produits hygiéniques','description'=>'Savon liquide et papier hygiénique','quantite'=>100,'unite_mesure'=>'Unité','budget_estimatif'=>3000,'categorie'=>'Hygiène','centre_cout'=>'DSI','statut'=>'soumise','demandeur_id'=>3,'validateur_id'=>null,'created_at'=>Carbon::now()->subDays(10),'updated_at'=>Carbon::now()->subDays(10)],
    	['numero'=>'DA-2026-00004','objet'=>'Outillage électricité','description'=>'Outils pour département électricité','quantite'=>20,'unite_mesure'=>'Unité','budget_estimatif'=>8000,'categorie'=>'Outillage','centre_cout'=>'DT','statut'=>'soumise','demandeur_id'=>3,'validateur_id'=>null,'created_at'=>Carbon::now()->subDays(5),'updated_at'=>Carbon::now()->subDays(5)],
    	['numero'=>'DA-2026-00005','objet'=>'Prestation lavage véhicules','description'=>'Lavage mensuel flotte véhicules','quantite'=>15,'unite_mesure'=>'Unité','budget_estimatif'=>1500,'categorie'=>'Services','centre_cout'=>'DRH','statut'=>'soumise','demandeur_id'=>3,'validateur_id'=>null,'created_at'=>Carbon::now()->subDays(2),'updated_at'=>Carbon::now()->subDays(2)],
]);

        // BONS DE COMMANDE
	DB::table('bons_commande')->insert([
    	['numero'=>'BC-2026-00001','fournisseur_id'=>1,'demande_achat_id'=>1,'statut'=>'confirmee','date_livraison_prevue'=>Carbon::now()->subDays(5),'montant_ht'=>4500,'tva'=>20,'montant_ttc'=>5400,'conditions_livraison'=>'Franco','lieu_livraison'=>'Casablanca','mode_paiement'=>'Virement','created_by'=>2,'created_at'=>Carbon::now()->subDays(20),'updated_at'=>Carbon::now()->subDays(20)],
    	['numero'=>'BC-2026-00002','fournisseur_id'=>2,'demande_achat_id'=>2,'statut'=>'confirmee','date_livraison_prevue'=>Carbon::now()->subDays(3),'montant_ht'=>2200,'tva'=>20,'montant_ttc'=>2640,'conditions_livraison'=>'Franco','lieu_livraison'=>'Casablanca','mode_paiement'=>'Virement','created_by'=>2,'created_at'=>Carbon::now()->subDays(18),'updated_at'=>Carbon::now()->subDays(18)],
    	['numero'=>'BC-2026-00003','fournisseur_id'=>3,'demande_achat_id'=>null,'statut'=>'envoyee','date_livraison_prevue'=>Carbon::now()->addDays(5),'montant_ht'=>1300,'tva'=>20,'montant_ttc'=>1560,'conditions_livraison'=>'Franco','lieu_livraison'=>'Casablanca','mode_paiement'=>'Chèque','created_by'=>2,'created_at'=>Carbon::now()->subDays(8),'updated_at'=>Carbon::now()->subDays(8)],
    	['numero'=>'BC-2026-00004','fournisseur_id'=>5,'demande_achat_id'=>null,'statut'=>'en_attente','date_livraison_prevue'=>Carbon::now()->addDays(10),'montant_ht'=>7000,'tva'=>20,'montant_ttc'=>8400,'conditions_livraison'=>'Franco','lieu_livraison'=>'Casablanca','mode_paiement'=>'Virement','created_by'=>2,'created_at'=>Carbon::now()->subDays(3),'updated_at'=>Carbon::now()->subDays(3)],
	]);

        // BONS DE RECEPTION
        DB::table('bons_reception')->insert([
            ['numero'=>'BR-2026-00001','bon_commande_id'=>1,'receptionnaire_id'=>5,'date_reception'=>Carbon::now()->subDays(5),'etat'=>'conforme','observations'=>'Livraison complète et conforme','created_at'=>Carbon::now()->subDays(5),'updated_at'=>Carbon::now()->subDays(5)],
            ['numero'=>'BR-2026-00002','bon_commande_id'=>2,'receptionnaire_id'=>5,'date_reception'=>Carbon::now()->subDays(3),'etat'=>'avec_reserves','observations'=>'2 rames manquantes sur 50','created_at'=>Carbon::now()->subDays(3),'updated_at'=>Carbon::now()->subDays(3)],
        ]);

        $this->command->info('Données de démonstration créées avec succès !');
    }
}