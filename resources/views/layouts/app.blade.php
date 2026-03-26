<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SGAF — @yield('title', 'Dashboard')</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --orange:      #F19741;
            --orange-dark: #D4792A;
            --vert:        #53BB5A;
            --vert-dark:   #3A9E41;
            --bleu:        #2D9BD6;
            --bleu-dark:   #1A7DB5;
            --bg:          #F4F7FB;
            --texte:       #1A2E44;
            --gris:        #8FA3B8;
            --gris-light:  #E8EFF7;
            --sidebar-w:   260px;
            --header-h:    64px;
            --shadow:      0 2px 12px rgba(45,155,214,0.08);
            --radius:      12px;
        }

        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--texte); min-height: 100vh; overflow-x: hidden; }

        /* ══ SIDEBAR ══ */
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: var(--sidebar-w); height: 100vh;
            background: white;
            border-right: 1px solid #EDF2F7;
            display: flex; flex-direction: column;
            z-index: 100; overflow: hidden;
            box-shadow: 2px 0 16px rgba(45,155,214,0.06);
            transition: transform 0.3s ease; /* Ajout d'une transition fluide */
        }

        .sidebar-logo {
            display: flex; align-items: center; gap: 10px;
            padding: 14px 16px;
            border-bottom: 2px solid #F0F6FF;
            min-height: var(--header-h);
            text-decoration: none;
        }
        .sidebar-logo img {
            height: 40px; width: auto; object-fit: contain;
            flex-shrink: 0;
        }
        .logo-text h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 16px; font-weight: 800;
            color: var(--texte); letter-spacing: 1px; line-height: 1;
        }
        .logo-text p {
            font-size: 9px; color: var(--gris);
            letter-spacing: 0.4px; text-transform: uppercase; margin-top: 3px;
        }

        .sidebar-nav { flex: 1; overflow-y: auto; padding: 12px 0; scrollbar-width: none; }
        .sidebar-nav::-webkit-scrollbar { display: none; }

        .nav-section { margin-bottom: 4px; }
        .nav-section-title {
            font-size: 9px; font-weight: 700;
            color: #B8CDD9;
            text-transform: uppercase; letter-spacing: 2px;
            padding: 12px 20px 4px;
        }

        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px 9px 16px;
            text-decoration: none;
            color: #5A7A94;
            font-size: 13.5px; font-weight: 500;
            transition: all 0.15s;
            margin: 1px 8px; border-radius: 9px;
        }
        .nav-item svg {
            width: 17px; height: 17px; flex-shrink: 0;
            stroke: currentColor; fill: none; stroke-width: 1.8;
        }
        .nav-item:hover {
            background: rgba(45,155,214,0.07);
            color: var(--bleu);
        }
        .nav-item.active {
            background: linear-gradient(135deg, var(--bleu) 0%, var(--bleu-dark) 100%);
            color: white; font-weight: 600;
            box-shadow: 0 4px 12px rgba(45,155,214,0.25);
        }
        .nav-badge {
            margin-left: auto;
            background: var(--orange); color: white;
            font-size: 10px; font-weight: 700;
            padding: 2px 7px; border-radius: 20px;
            min-width: 20px; text-align: center;
        }

        .sidebar-user {
            padding: 12px;
            border-top: 1px solid #EDF2F7;
        }
        .user-card {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 10px;
            background: var(--bg);
            border: 1px solid #EDF2F7;
            transition: background 0.15s;
        }
        .user-card:hover { background: #EDF2F7; }
        .user-avatar {
            width: 34px; height: 34px; border-radius: 9px;
            background: linear-gradient(135deg, var(--bleu), var(--vert));
            display: flex; align-items: center; justify-content: center;
            font-family: 'Outfit', sans-serif; font-weight: 700;
            font-size: 12px; color: white; flex-shrink: 0;
        }
        .user-info { flex: 1; min-width: 0; }
        .user-name { font-size: 12px; font-weight: 600; color: var(--texte); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-role { font-size: 10px; color: var(--gris); margin-top: 1px; }
        .user-logout {
            background: none; border: none; cursor: pointer;
            color: var(--gris); display: flex; align-items: center;
            padding: 5px; border-radius: 6px; transition: all 0.15s;
        }
        .user-logout:hover { color: #E53E3E; background: rgba(229,62,62,0.08); }
        .user-logout svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; }

        /* NOUVEAU : Overlay pour masquer le fond sur mobile */
        .sidebar-overlay {
            display: none; position: fixed; top: 0; left: 0;
            width: 100%; height: 100vh; background: rgba(0,0,0,0.4);
            z-index: 95; opacity: 0; transition: opacity 0.3s ease;
        }
        .sidebar-overlay.active { display: block; opacity: 1; }

        /* ══ HEADER ══ */
        .header {
            position: fixed; top: 0; left: var(--sidebar-w); right: 0;
            height: var(--header-h); background: white;
            border-bottom: 1px solid #EDF2F7;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px; z-index: 90;
            box-shadow: 0 1px 8px rgba(45,155,214,0.05);
            transition: left 0.3s ease, padding 0.3s ease;
        }
        .header-left { display: flex; align-items: center; gap: 14px; }
        
        /* NOUVEAU : Bouton Menu Hamburger (caché par défaut) */
        .mobile-toggle {
            display: none; background: none; border: none;
            color: var(--texte); cursor: pointer; padding: 5px;
            border-radius: 6px; margin-right: 5px;
        }
        .mobile-toggle svg { width: 24px; height: 24px; stroke: currentColor; fill: none; stroke-width: 2; }
        .mobile-toggle:hover { background: #EDF2F7; }

        .header-left img { height: 40px; width: auto; object-fit: contain; flex-shrink: 0; }
        .page-title { font-family: 'Outfit', sans-serif; font-size: 17px; font-weight: 700; color: var(--texte); line-height: 1; }
        .breadcrumb { display: flex; align-items: center; gap: 5px; font-size: 12px; color: var(--gris); margin-top: 3px; }
        .breadcrumb a { color: var(--gris); text-decoration: none; }
        .breadcrumb a:hover { color: var(--bleu); }
        .header-right { display: flex; align-items: center; gap: 6px; }
        .header-btn {
            width: 38px; height: 38px; border-radius: 10px; border: none;
            background: var(--bg); color: var(--gris);
            cursor: pointer; display: flex; align-items: center;
            justify-content: center; transition: all 0.15s; text-decoration: none;
        }
        .header-btn:hover { background: rgba(45,155,214,0.08); color: var(--bleu); }
        .header-btn svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 1.8; }

        /* ══ MAIN ══ */
        .main-content {
            margin-left: var(--sidebar-w); margin-top: var(--header-h);
            padding: 28px; min-height: calc(100vh - var(--header-h));
            transition: margin-left 0.3s ease, padding 0.3s ease;
        }

        /* ══ STATS ══ */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin-bottom: 24px; }
        .stat-card {
            background: white; border-radius: var(--radius); padding: 20px;
            box-shadow: var(--shadow);
            display: flex; align-items: center; gap: 14px;
            transition: transform 0.2s, box-shadow 0.2s;
            border: 1px solid #EDF2F7;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(45,155,214,0.1); }
        .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .stat-icon svg { width: 22px; height: 22px; stroke: currentColor; fill: none; stroke-width: 1.8; }
        .stat-icon.blue   { background: rgba(45,155,214,0.10);  color: var(--bleu); }
        .stat-icon.green  { background: rgba(83,187,90,0.10);   color: var(--vert); }
        .stat-icon.orange { background: rgba(241,151,65,0.12);  color: var(--orange); }
        .stat-icon.red    { background: rgba(229,62,62,0.10);   color: #E53E3E; }
        .stat-value { font-family: 'Outfit', sans-serif; font-size: 26px; font-weight: 700; color: var(--texte); line-height: 1; margin-bottom: 3px; }
        .stat-label { font-size: 12px; color: var(--gris); }

        /* ══ CARD & REST OF CSS ══ */
        .card { background: white; border-radius: var(--radius); box-shadow: var(--shadow); border: 1px solid #EDF2F7; overflow: hidden; margin-bottom: 20px; }
        .card-header { display: flex; align-items: center; justify-content: space-between; padding: 16px 22px; border-bottom: 1px solid #F4F8FF; flex-wrap: wrap; gap: 10px;}
        .card-title { font-family: 'Outfit', sans-serif; font-size: 15px; font-weight: 700; color: var(--texte); }
        .card-subtitle { font-size: 12px; color: var(--gris); margin-top: 2px; }

        .btn { display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px; border-radius: 9px; font-size: 13px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; border: none; text-decoration: none; transition: all 0.18s; white-space: nowrap; }
        .btn svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
        .btn-primary { background: var(--bleu); color: white; }
        .btn-primary:hover { background: var(--bleu-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(45,155,214,0.3); }
        .btn-success { background: var(--vert); color: white; }
        .btn-success:hover { background: var(--vert-dark); transform: translateY(-1px); }
        .btn-warning { background: var(--orange); color: white; }
        .btn-warning:hover { background: var(--orange-dark); }
        .btn-danger { background: #E53E3E; color: white; }
        .btn-danger:hover { background: #C62828; }
        .btn-outline { background: transparent; color: var(--bleu); border: 1.5px solid #D8E8F4; }
        .btn-outline:hover { background: rgba(45,155,214,0.06); border-color: var(--bleu); }
        .btn-sm { padding: 6px 12px; font-size: 12px; border-radius: 7px; }

        .table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; min-width: 600px; } /* min-width empêche le tableau d'être écrasé */
        thead th { padding: 10px 18px; text-align: left; font-size: 11px; font-weight: 600; color: var(--gris); text-transform: uppercase; letter-spacing: 0.8px; background: #FAFCFF; border-bottom: 1px solid #EDF2F7; white-space: nowrap; }
        tbody td { padding: 12px 18px; font-size: 13.5px; color: var(--texte); border-bottom: 1px solid #F4F8FF; vertical-align: middle; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: #FAFCFF; }

        .badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; white-space: nowrap; }
        .badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: currentColor; flex-shrink: 0; }
        .badge-actif            { background: rgba(83,187,90,0.1);   color: #2E8B35; }
        .badge-inactif          { background: rgba(143,163,184,0.15);color: #607D8B; }
        /* ... autres badges (j'ai gardé tous tes styles intacts, juste raccourcis pour la vue) ... */

        .actions-wrap { display: flex; align-items: center; gap: 4px; }
        .action-btn { width: 30px; height: 30px; border-radius: 7px; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.15s; background: transparent; text-decoration: none; }
        .action-btn svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; }
        .action-view   { color: var(--bleu); }
        .action-edit   { color: var(--vert); }
        .action-delete { color: #E53E3E; }
        .action-view:hover   { background: rgba(45,155,214,0.1); }
        .action-edit:hover   { background: rgba(83,187,90,0.1); }
        .action-delete:hover { background: rgba(229,62,62,0.1); }

        .pagination { display: flex; align-items: center; justify-content: space-between; padding: 14px 22px; border-top: 1px solid #EDF2F7; flex-wrap: wrap; gap: 10px;}
        .pagination-info { font-size: 12px; color: var(--gris); }
        nav[aria-label] { display: flex; align-items: center; flex-wrap: wrap; gap: 5px;}
        nav[aria-label] span, nav[aria-label] a { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; border: 1.5px solid #EDF2F7; background: white; color: var(--texte); font-size: 13px; text-decoration: none; margin: 0; transition: all 0.15s; }
        nav[aria-label] a:hover { border-color: var(--bleu); color: var(--bleu); }
        nav[aria-label] span[aria-current] { background: var(--bleu); border-color: var(--bleu); color: white; }
        
        .filters-bar { display: flex; align-items: center; gap: 12px; padding: 12px 22px; border-bottom: 1px solid #EDF2F7; flex-wrap: wrap; }
        .filter-wrap { position: relative; flex: 1; min-width: 180px; }
        .filter-search-icon { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: var(--gris); pointer-events: none; }
        .filter-search-icon svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; }
        .filter-input { width: 100%; padding: 9px 14px 9px 36px; border: 1.5px solid #EDF2F7; border-radius: 9px; font-size: 13px; font-family: 'Inter', sans-serif; color: var(--texte); background: var(--bg); outline: none; transition: all 0.18s; }
        .filter-input:focus { border-color: var(--bleu); background: white; box-shadow: 0 0 0 3px rgba(45,155,214,0.07); }
        .filter-select { padding: 9px 14px; border: 1.5px solid #EDF2F7; border-radius: 9px; font-size: 13px; font-family: 'Inter', sans-serif; color: var(--texte); background: white; outline: none; cursor: pointer; transition: border-color 0.18s; width: 100%;}
        .filter-select:focus { border-color: var(--bleu); }

        .alert { display: flex; align-items: center; gap: 12px; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-size: 13.5px; animation: slideIn 0.3s ease; }
        .alert svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
        .alert-success { background: rgba(83,187,90,0.08);  border: 1px solid rgba(83,187,90,0.2);  color: #2E8B35; }
        .alert-error   { background: rgba(229,62,62,0.08);  border: 1px solid rgba(229,62,62,0.2);  color: #C62828; }
        .alert-warning { background: rgba(241,151,65,0.08); border: 1px solid rgba(241,151,65,0.2); color: var(--orange-dark); }
        @keyframes slideIn { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }

        .form-card { background: white; border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden; border: 1px solid #EDF2F7; margin-bottom: 20px;}
        .form-card-header { padding: 16px 26px; border-bottom: 1px solid #EDF2F7; display: flex; align-items: center; justify-content: space-between; }
        .form-card-body { padding: 26px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .form-row-3 { grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;}
        .form-row:last-child { margin-bottom: 0; }
        .form-group-inner label { display: block; font-size: 13px; font-weight: 500; color: var(--texte); margin-bottom: 7px; }
        .form-control { width: 100%; padding: 10px 14px; border: 1.5px solid #EDF2F7; border-radius: 9px; font-size: 13.5px; font-family: 'Inter', sans-serif; color: var(--texte); background: var(--bg); outline: none; transition: all 0.18s; }
        .form-control:focus { border-color: var(--bleu); background: white; box-shadow: 0 0 0 3px rgba(45,155,214,0.07); }
        select.form-control { cursor: pointer; }
        textarea.form-control { resize: vertical; min-height: 100px; }
        .form-card-footer { padding: 16px 26px; border-top: 1px solid #EDF2F7; display: flex; justify-content: flex-end; gap: 12px; background: #FAFCFF; }

        .empty-state { text-align: center; padding: 50px 20px; }
        .empty-icon { width: 64px; height: 64px; border-radius: 16px; background: rgba(45,155,214,0.06); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; color: var(--gris); }
        .empty-icon svg { width: 28px; height: 28px; stroke: currentColor; fill: none; stroke-width: 1.5; }
        .empty-state h4 { font-family: 'Outfit', sans-serif; font-size: 16px; font-weight: 600; color: var(--texte); margin-bottom: 6px; }
        .empty-state p { font-size: 13px; color: var(--gris); max-width: 280px; margin: 0 auto 16px; line-height: 1.6; }

        /* ══ NOUVELLES MEDIA QUERIES COMPLETES ══ */
        
        /* Pour les Tablettes (iPad, etc.) */
        @media (max-width: 1024px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }

        /* Pour les Mobiles */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); } /* S'active via le bouton */
            
            .header { left: 0; padding: 0 16px; }
            .main-content { margin-left: 0; padding: 16px; } /* Moins de padding sur les côtés */
            
            .mobile-toggle { display: block; } /* On affiche le bouton menu */
            .header-left img { display: none; } /* On cache le logo du header pour gagner de la place */
            
            /* On réorganise les formulaires en 1 seule colonne */
            .form-row, .form-row-3 { grid-template-columns: 1fr; gap: 16px; }
            
            /* On passe les statistiques sur 1 seule colonne */
            .stats-grid { grid-template-columns: 1fr; gap: 12px; }
            
            /* Ajustements divers pour petits écrans */
            .page-title { font-size: 15px; }
            .breadcrumb { display: none; } /* Cache le fil d'ariane sur mobile */
            .card-header { flex-direction: column; align-items: flex-start; }
            .form-card-footer { justify-content: center; flex-direction: column-reverse; }
            .form-card-footer .btn { width: 100%; justify-content: center; }
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="sidebar">
    <a href="{{ route('dashboard') }}" class="sidebar-logo">
        <img src="{{ asset('images/logo.png') }}" alt="" title="">
        <div class="logo-text">
            <h1>SGAF</h1>
            <p>SRM Casablanca-Settat</p>
        </div>
    </a>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-section-title">Principal</div>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Tableau de bord
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Achats</div>
            @can('fournisseurs.voir')
            @if(Route::has('fournisseurs.index'))
            <a href="{{ route('fournisseurs.index') }}" class="nav-item {{ request()->routeIs('fournisseurs.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Fournisseurs
            </a>
            @endif
            @endcan

            @can('da.voir')
            @if(Route::has('demandes.index'))
            <a href="{{ route('demandes.index') }}" class="nav-item {{ request()->routeIs('demandes.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                Demandes d'Achats
                @php try { $pending = \App\Models\DemandeAchat::where('statut','soumise')->count(); } catch(\Exception $e) { $pending = 0; } @endphp
                @if($pending > 0)<span class="nav-badge">{{ $pending }}</span>@endif
            </a>
            @endif
            @endcan

            @can('bc.voir')
            @if(Route::has('commandes.index'))
            <a href="{{ route('commandes.index') }}" class="nav-item {{ request()->routeIs('commandes.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                Bons de Commande
            </a>
            @endif
            @endcan

            @can('br.voir')
            @if(Route::has('receptions.index'))
            <a href="{{ route('receptions.index') }}" class="nav-item {{ request()->routeIs('receptions.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><path d="M12 22V7"/></svg>
                Réceptions
            </a>
            @endif
            @endcan
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Suivi</div>

            @can('dashboard.voir')
            @if(Route::has('statistiques.index'))
            <a href="{{ route('statistiques.index') }}" class="nav-item {{ request()->routeIs('statistiques.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                Statistiques
            </a>
            @endif
            @endcan

            @if(Route::has('suivi.index'))
            <a href="{{ route('suivi.index') }}" class="nav-item {{ request()->routeIs('suivi.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                Suivi Commandes
            </a>
            @endif

            @can('audit.voir')
            @if(Route::has('audit.index'))
            <a href="{{ route('audit.index') }}" class="nav-item {{ request()->routeIs('audit.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Journal d'Audit
            </a>
            @endif
            @endcan
        </div>
    </nav>

    <div class="sidebar-user">
        <div class="user-card">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}{{ strtoupper(substr(auth()->user()->prenom ?? '', 0, 1)) }}
            </div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }} {{ auth()->user()->prenom }}</div>
                <div class="user-role">{{ ucfirst(auth()->user()->getRoleNames()->first() ?? 'Utilisateur') }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="user-logout" title="">
                    <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                </button>
            </form>
        </div>
    </div>
</aside>

<header class="header">
    <div class="header-left">
        <button class="mobile-toggle" id="mobileToggle">
            <svg viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>

        <img src="{{ asset('images/logo.png') }}" alt="" title="" style="height:40px;width:auto;object-fit:contain;">
        <div>
            <div class="page-title">@yield('page-title', 'Dashboard')</div>
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Accueil</a>
                <span>›</span>
                @yield('breadcrumb')
            </div>
        </div>
    </div>
    <div class="header-right">
        <a href="{{ route('profile.edit') }}" class="header-btn" title="">
            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </a>
    </div>
</header>

<main class="main-content">
    @if(session('success'))
    <div class="alert alert-success">
        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        {{ session('error') }}
    </div>
    @endif

    @if(session('warning'))
    <div class="alert alert-warning">
        <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        {{ session('warning') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-error">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div>@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>
    </div>
    @endif

    @yield('content')
</main>

@stack('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileToggle = document.getElementById('mobileToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        if(mobileToggle && sidebar && overlay) {
            // Ouvrir le menu
            mobileToggle.addEventListener('click', function() {
                sidebar.classList.add('active');
                overlay.classList.add('active');
            });

            // Fermer le menu en cliquant sur le fond noir
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });
        }
    });
</script>

</body>
</html>