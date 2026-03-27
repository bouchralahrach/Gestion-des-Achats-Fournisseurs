<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'fournisseurs.voir','fournisseurs.creer','fournisseurs.modifier','fournisseurs.supprimer',
            'da.voir','da.creer','da.valider',
            'bc.voir','bc.creer','bc.valider','bc.envoyer',
            'br.voir','br.creer',
            'dashboard.voir','audit.voir','users.gerer',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        $rolesPerms = [
            'admin'          => $permissions,
            'acheteur'       => ['fournisseurs.voir','fournisseurs.creer','fournisseurs.modifier','fournisseurs.supprimer','da.voir','da.valider','bc.voir','bc.creer','bc.valider','bc.envoyer','br.voir','dashboard.voir','audit.voir'],
            'demandeur'      => ['da.voir','da.creer','dashboard.voir'],
            'validateur'     => ['da.voir','da.valider','bc.voir','dashboard.voir'],
            'magasinier'     => ['br.voir','br.creer','bc.voir','dashboard.voir'],
            'comptable'      => ['bc.voir','br.voir','dashboard.voir','audit.voir'],
            'receptionnaire' => ['br.voir','br.creer','bc.voir','dashboard.voir'],
        ];

        foreach ($rolesPerms as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->permissions()->detach();
            foreach ($perms as $perm) {
                $permission = Permission::where('name', $perm)->first();
                if ($permission) $role->permissions()->attach($permission->id);
            }
            echo $roleName . " OK\n";
        }

        $this->command->info('Rôles et permissions créés avec succès !');
    }
}