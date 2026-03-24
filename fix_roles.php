<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Trouver les IDs des rôles
$magasinier = DB::table('roles')->where('name','magasinier')->first();
$comptable   = DB::table('roles')->where('name','comptable')->first();

// Permissions pour magasinier
$perms_mag = ['br.voir','br.creer','bc.voir','dashboard.voir'];
// Permissions pour comptable
$perms_comp = ['bc.voir','br.voir','dashboard.voir','audit.voir'];

// Supprimer anciennes permissions
DB::table('role_has_permissions')->where('role_id', $magasinier->id)->delete();
DB::table('role_has_permissions')->where('role_id', $comptable->id)->delete();

// Ajouter nouvelles permissions
foreach ($perms_mag as $perm) {
    $p = DB::table('permissions')->where('name', $perm)->first();
    if ($p) DB::table('role_has_permissions')->insert(['permission_id'=>$p->id,'role_id'=>$magasinier->id]);
}
foreach ($perms_comp as $perm) {
    $p = DB::table('permissions')->where('name', $perm)->first();
    if ($p) DB::table('role_has_permissions')->insert(['permission_id'=>$p->id,'role_id'=>$comptable->id]);
}

echo "magasinier OK\n";
echo "comptable OK\n";
echo "Terminé!\n";