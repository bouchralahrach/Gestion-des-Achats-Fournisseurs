<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuiviCommandesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('suivi_commandes')->truncate();

        $data = [
            ['date_demande'=>'2024-10-03','nature'=>'CHAUSSURES','numero'=>'60207864','fournisseur'=>'RESTEL SARL','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2024-10-18','nature'=>'PAPIER BLANC ROSE','numero'=>'60208049','fournisseur'=>'NAVARA BUREAU','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2024-10-23','nature'=>'Prestation coupure','numero'=>'60208199','fournisseur'=>'ZIANELEC SARL','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2024-10-23','nature'=>'Prestation coupure','numero'=>'60208200','fournisseur'=>'ZIANELEC SARL','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2024-10-29','nature'=>'Outillage','numero'=>'60208256','fournisseur'=>'Ste Spéciale Quincaillerie','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2024-10-29','nature'=>'Outillage','numero'=>'60208258','fournisseur'=>'STE ste instruments','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2024-10-29','nature'=>'Outillage','numero'=>'60208255','fournisseur'=>'ste ISODEL','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2024-10-29','nature'=>'Outillage','numero'=>'60208254','fournisseur'=>'ste ISODEL','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2024-10-31','nature'=>'Outillage','numero'=>'60208287','fournisseur'=>'Ste Spéciale Quincaillerie','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2024-11-27','nature'=>'Prestation coupure','numero'=>'60208789','fournisseur'=>'ZIANELEC SARL','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2024-11-27','nature'=>'Prestation coupure','numero'=>'60208790','fournisseur'=>'ZIANELEC SARL','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2024-12-09','nature'=>'Outillage','numero'=>'60208995','fournisseur'=>'Ste Spéciale Quincaillerie','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2024-12-09','nature'=>'Outillage','numero'=>'60208993','fournisseur'=>'Ste Spéciale Quincaillerie','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2024-12-09','nature'=>'Outillage','numero'=>'60208996','fournisseur'=>'Ste Spéciale Quincaillerie','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2024-12-09','nature'=>'PANNEAU SIGNALISATION','numero'=>'60208998','fournisseur'=>'CAPFEI','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2024-12-20','nature'=>'Outillage','numero'=>'60209206','fournisseur'=>'Ste Spéciale Quincaillerie','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2024-12-20','nature'=>'Outillage','numero'=>'60209207','fournisseur'=>'Ste Spéciale Quincaillerie','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2024-12-20','nature'=>'Outillage','numero'=>'60209095','fournisseur'=>'Ste Spéciale Quincaillerie','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2024-12-27','nature'=>'Prestation coupure','numero'=>'60209451','fournisseur'=>'ZIANELEC SARL','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2024-12-27','nature'=>'Prestation coupure','numero'=>'60209450','fournisseur'=>'ZIANELEC SARL','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2024-12-27','nature'=>'CHAUSSURES','numero'=>'60209364','fournisseur'=>'SAFETY AND SECURITY','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-01-06','nature'=>'PAPIER BLANC ROSE','numero'=>'60209572','fournisseur'=>'NAVARA BUREAU','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-01-23','nature'=>'PRODUITS HYGIENIQUES','numero'=>'60209877','fournisseur'=>'MANAGEMENT CLEAN SERVICE','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-01-24','nature'=>'Papier blanc et rose','numero'=>'60209894','fournisseur'=>'NAVARA BUREAU','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-01-24','nature'=>'Prestation lavage véhicule','numero'=>'60209867','fournisseur'=>'PRO-HYG','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-01-24','nature'=>'Prestation lavage véhicule','numero'=>'60209869','fournisseur'=>'PRO-HYG','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-01-24','nature'=>'Prestation coupure','numero'=>'60209915','fournisseur'=>'ZIANELEC SARL','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-01-24','nature'=>'Prestation coupure','numero'=>'60209914','fournisseur'=>'ZIANELEC SARL','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-01-28','nature'=>'Prestation coupure','numero'=>'60209916','fournisseur'=>'ZIANELEC SARL','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-03-14','nature'=>'Prestation coupure','numero'=>'60210540','fournisseur'=>'ZIANELEC SARL','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-03-19','nature'=>'Prestation lavage véhicule','numero'=>'60210667','fournisseur'=>'PRO-HYG','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-04-11','nature'=>'PRODUITS HYGIENIQUES','numero'=>'60210966','fournisseur'=>'MANAGEMENT CLEAN SERVICE','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-04-11','nature'=>'PAPIER BLANC ROSE','numero'=>'60210965','fournisseur'=>'NAVARA BUREAU','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-04-14','nature'=>'CHAUSSURES','numero'=>'60209366','fournisseur'=>'FOUTRAV','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-04-14','nature'=>'FOURNITURES DE BUREAU','numero'=>'60210999','fournisseur'=>'SOCIETE NOUVELLE PAPETRIE CARDON','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-04-14','nature'=>'FOURNITURES DE BUREAU','numero'=>'60211000','fournisseur'=>'SOCIETE NOUVELLE PAPETRIE CARDON','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-04-15','nature'=>'Prestation habillage Agence','numero'=>'10000594','fournisseur'=>null,'livraison'=>'ok','type'=>"Demande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-04-22','nature'=>'ENVELOPPE - PAPIER ENTETE','numero'=>'60211099','fournisseur'=>"ETOILE D'OR",'livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-04-22','nature'=>'FOURNITURES DE BUREAU','numero'=>'60211097','fournisseur'=>'SOCIETE NOUVELLE PAPETRIE CARDON','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-04-30','nature'=>'Outillage','numero'=>'60211202','fournisseur'=>'Ste Spéciale Quincaillerie','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-04-30','nature'=>'Outillage','numero'=>'60211209','fournisseur'=>'Ste Spéciale Quincaillerie','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-04-30','nature'=>'Outillage','numero'=>'60211201','fournisseur'=>'Ste Spéciale Quincaillerie','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-04-30','nature'=>'Outillage','numero'=>'60211200','fournisseur'=>'Ste Spéciale Quincaillerie','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-05-06','nature'=>'DRAPEAUX','numero'=>'60211213','fournisseur'=>'BEST DECOR','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-05-07','nature'=>'Prestation Relevé / Distribution','numero'=>'10001684','fournisseur'=>null,'livraison'=>'En cours','type'=>"Demande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-05-07','nature'=>'Reception retraités 2023-2024','numero'=>'5200000206','fournisseur'=>'GANNOUNE OUNGE','livraison'=>'2025-09-05','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-05-12','nature'=>'Prestation Distribution factures','numero'=>'10001742','fournisseur'=>null,'livraison'=>'En cours','type'=>"Demande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-06-04','nature'=>'Prestation de la coupure','numero'=>'10002128','fournisseur'=>null,'livraison'=>'En cours','type'=>"Demande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-06-30','nature'=>'Prestation Enseignes Agence','numero'=>'10002108','fournisseur'=>null,'livraison'=>'En cours','type'=>"Demande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-07-15','nature'=>'Commande GE','numero'=>'5200000806','fournisseur'=>'ELECTROLOG','livraison'=>'En cours','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-07-29','nature'=>'Déplacement Coffre fort','numero'=>'4600000263','fournisseur'=>'AFRICA SOURCING','livraison'=>'2025-08-18','type'=>"Demande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-11-27','nature'=>'Prestation lavage véhicule','numero'=>'60208793','fournisseur'=>'PRO-HYG','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            ['date_demande'=>'2025-11-27','nature'=>'Prestation lavage véhicule','numero'=>'60208792','fournisseur'=>'PRO-HYG','livraison'=>'ok','type'=>"Commande d'achat",'feuille'=>'Feuil1'],
            // DA Namaa
            ['date_demande'=>null,'nature'=>"Prestation d'édition des factures DP7",'numero'=>'10004176','fournisseur'=>null,'livraison'=>null,'type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>null,'nature'=>"Contrat coupure/rebrachement compteurs (2026)",'numero'=>'0010003905','fournisseur'=>null,'livraison'=>null,'type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>null,'nature'=>"Contrat distribution factures eau/électricité",'numero'=>'0010003910','fournisseur'=>null,'livraison'=>null,'type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>null,'nature'=>"Contrat coupure/rebrachement compteurs (2025)",'numero'=>'0010002128','fournisseur'=>null,'livraison'=>null,'type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>null,'nature'=>"Contrat relevé compteurs eau/électricité",'numero'=>'0010004149','fournisseur'=>null,'livraison'=>null,'type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>null,'nature'=>"Contrat relevé compteurs eau/électricité",'numero'=>'0010001684','fournisseur'=>null,'livraison'=>null,'type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>null,'nature'=>"Contrat distribution factures et avis eau/électricité",'numero'=>'0010001742','fournisseur'=>null,'livraison'=>null,'type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>'2025-08-18','nature'=>"Déménagement coffre caisse principale agence Hassan 2",'numero'=>'4600000263','fournisseur'=>'AFRICA SOURCING','livraison'=>null,'type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>null,'nature'=>"Déménagement de coffret",'numero'=>'10002490','fournisseur'=>null,'livraison'=>null,'type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>'2025-07-17','nature'=>"Déplacement coffre fort agence DP7",'numero'=>'2025018','fournisseur'=>'AFRICA SOURCING','livraison'=>null,'type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>'2025-07-16','nature'=>"Déplacement coffre fort agence Mohammedia",'numero'=>'01215','fournisseur'=>'MADOMELEC','livraison'=>null,'type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>'2025-07-18','nature'=>"Déplacement coffre fort",'numero'=>null,'fournisseur'=>'FATAL DISTRIBUTION SARL AU','livraison'=>null,'type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>'2024-09-19','nature'=>"Déménagement coffre agence DP7 (RDC → 1er étage)",'numero'=>'2024011','fournisseur'=>'AFRICA SOURCING','livraison'=>'2024-09-20','type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>'2024-09-20','nature'=>"Déménagement coffre agence DP7 (RDC → 1er étage)",'numero'=>'60207377','fournisseur'=>'AFRICA SOURCING','livraison'=>null,'type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>'2025-05-30','nature'=>"Contrat distribution factures et avis eau/électricité",'numero'=>'0010001742','fournisseur'=>null,'livraison'=>null,'type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>'2025-02-24','nature'=>"Travaux impression/pose support communication agence Hassan 2",'numero'=>'0010000594','fournisseur'=>null,'livraison'=>'10-24-2024','type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>'2025-02-25','nature'=>"Enseignes facades DP et agence Hassan 2 Mohammedia",'numero'=>'0010002108','fournisseur'=>null,'livraison'=>null,'type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>null,'nature'=>"COCKTAIL",'numero'=>'1001937','fournisseur'=>'GANNOUCH LOUNGE CULINAIRE','livraison'=>'2025-05-09','type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>null,'nature'=>"LOCATION EQUIPEMENT",'numero'=>'1001937','fournisseur'=>'GANNOUCH LOUNGE CULINAIRE','livraison'=>'2025-05-09','type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>null,'nature'=>"GRP ELEC diesel 250kVA 3ph MOBIL-insonor",'numero'=>'5200000806','fournisseur'=>'ELECTROLOC','livraison'=>null,'type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>null,'nature'=>"RAME DE PAPIER A4",'numero'=>'5200001967','fournisseur'=>'NAVAR BURO','livraison'=>'2025-09-30','type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>null,'nature'=>"RAME DE PAPIER A4 ROSE",'numero'=>'5200001967','fournisseur'=>'NAVAR BURO','livraison'=>'2025-09-30','type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>null,'nature'=>"SAVON LIQUIDE",'numero'=>'5200001964','fournisseur'=>'MANAGEMENT CLEAN SERVICE','livraison'=>'2025-10-01','type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>null,'nature'=>"ROULEAU PAPIER HYGIENIQUE",'numero'=>'5200001964','fournisseur'=>'MANAGEMENT CLEAN SERVICE','livraison'=>'2025-10-01','type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>null,'nature'=>"Habillage de l'agence",'numero'=>'4500000203','fournisseur'=>'PIXAD','livraison'=>'2025-07-24','type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>null,'nature'=>"Fourniture de bureau",'numero'=>'5200002464','fournisseur'=>'STE NOUVELLE PAPETER','livraison'=>null,'type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>null,'nature'=>"Fourniture de bureau",'numero'=>'5200002465','fournisseur'=>'STE NOUVELLE PAPETER','livraison'=>null,'type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>'2025-08-27','nature'=>"Outillage département électricité",'numero'=>'5200002013','fournisseur'=>'ISODEL','livraison'=>null,'type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
            ['date_demande'=>'2025-10-21','nature'=>"Achat outillages et équipements",'numero'=>'5200002718','fournisseur'=>null,'livraison'=>'2025-10-23','type'=>"Commande d'achat",'feuille'=>'DA Namaa'],
        ];

        foreach ($data as &$row) {
            $row['created_at'] = now();
            $row['updated_at'] = now();
        }

        DB::table('suivi_commandes')->insert($data);
    }
}