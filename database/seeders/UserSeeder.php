<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Créer les rôles manquants
        Role::firstOrCreate(['name' => 'magasinier']);
        Role::firstOrCreate(['name' => 'comptable']);

        // 1. ADMINISTRATEUR
        $admin = User::firstOrCreate(
            ['email' => 'admin@srm-cs.ma'],
            [
                'name'     => 'Administrateur',
                'prenom'   => 'SGAF',
                'password' => Hash::make('Admin@1234'),
            ]
        );
        $admin->syncRoles('admin');

        // 2. RESPONSABLE ACHATS
        $acheteur = User::firstOrCreate(
            ['email' => 'achats@srm-cs.ma'],
            [
                'name'     => 'Responsable',
                'prenom'   => 'Achats',
                'password' => Hash::make('Achats@1234'),
            ]
        );
        $acheteur->syncRoles('acheteur');

        // 3. DEMANDEUR
        $demandeur = User::firstOrCreate(
            ['email' => 'demandeur@srm-cs.ma'],
            [
                'name'     => 'Demandeur',
                'prenom'   => 'SRM',
                'password' => Hash::make('Demandeur@1234'),
            ]
        );
        $demandeur->syncRoles('demandeur');

        // 4. VALIDATEUR
        $validateur = User::firstOrCreate(
            ['email' => 'validateur@srm-cs.ma'],
            [
                'name'     => 'Validateur',
                'prenom'   => 'SRM',
                'password' => Hash::make('Validateur@1234'),
            ]
        );
        $validateur->syncRoles('validateur');

        // 5. MAGASINIER
        $magasinier = User::firstOrCreate(
            ['email' => 'magasinier@srm-cs.ma'],
            [
                'name'     => 'Magasinier',
                'prenom'   => 'SRM',
                'password' => Hash::make('Magasin@1234'),
            ]
        );
        $magasinier->syncRoles('magasinier');

        // 6. COMPTABLE
        $comptable = User::firstOrCreate(
            ['email' => 'comptable@srm-cs.ma'],
            [
                'name'     => 'Comptable',
                'prenom'   => 'SRM',
                'password' => Hash::make('Comptable@1234'),
            ]
        );
        $comptable->syncRoles('comptable');

        $this->command->info('✅ Les 6 utilisateurs créés avec succès !');
    }
}