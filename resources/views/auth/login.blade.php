<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion — SGAF | SRM Casablanca-Settat</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; font-family: 'Inter', sans-serif; }

        :root {
            --orange: #F19741;
            --vert:   #53BB5A;
            --bleu:   #2D9BD6;
        }

        body { display: flex; min-height: 100vh; background: #F4F7FB; }
        .login-card { display: flex; width: 100%; min-height: 100vh; }

        /* ══ PANNEAU GAUCHE ══ */
        .brand-panel {
            width: 42%;
            background: linear-gradient(160deg, #0A3D62 0%, #063049 60%, #041E30 100%);
            padding: 52px 48px;
            display: flex; flex-direction: column; justify-content: space-between;
            position: relative; overflow: hidden;
        }

        /* Cercles décoratifs */
        .brand-panel::before {
            content: ''; position: absolute;
            top: -120px; right: -80px;
            width: 320px; height: 320px; border-radius: 50%;
            background: radial-gradient(circle, rgba(45,155,214,0.18) 0%, transparent 70%);
            pointer-events: none;
        }
        .brand-panel::after {
            content: ''; position: absolute;
            bottom: -100px; left: -60px;
            width: 260px; height: 260px; border-radius: 50%;
            background: radial-gradient(circle, rgba(83,187,90,0.12) 0%, transparent 70%);
            pointer-events: none;
        }
        .deco-ring-1 {
            position: absolute; top: 35%; right: -60px;
            width: 200px; height: 200px; border-radius: 50%;
            border: 1px solid rgba(241,151,65,0.15); pointer-events: none;
        }
        .deco-ring-2 {
            position: absolute; bottom: 25%; left: -50px;
            width: 150px; height: 150px; border-radius: 50%;
            border: 1px solid rgba(45,155,214,0.12); pointer-events: none;
        }

        /* Logo */
        .brand-logo {
            display: flex; align-items: center; gap: 12px;
            position: relative; z-index: 1;
        }
        .brand-logo img {
            height: 50px; width: auto; object-fit: contain;
            background: white; padding: 6px 8px; border-radius: 10px; flex-shrink: 0;
        }
        .brand-logo-text h1 {
            font-family: 'Outfit', sans-serif; font-size: 22px; font-weight: 800;
            color: white; letter-spacing: 2px; line-height: 1;
        }
        .brand-logo-text p {
            font-size: 9px; color: rgba(255,255,255,0.4);
            text-transform: uppercase; letter-spacing: 0.8px; margin-top: 4px;
        }

        /* Contenu central */
        .brand-content { position: relative; z-index: 1; flex: 1; display: flex; flex-direction: column; justify-content: center; padding: 40px 0; }

        .brand-badge {
            display: inline-flex; align-items: center; gap: 8px;
            border: 1px solid rgba(83,187,90,0.3);
            background: rgba(83,187,90,0.08);
            color: #7EDB84; font-size: 10px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1.2px;
            padding: 6px 14px; border-radius: 20px;
            margin-bottom: 24px; width: fit-content;
        }
        .brand-badge span {
            width: 6px; height: 6px; border-radius: 50%;
            background: var(--vert); animation: blink 2s infinite;
        }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.2} }

        .brand-title {
            font-family: 'Outfit', sans-serif; font-size: 34px; font-weight: 800;
            color: white; line-height: 1.2; margin-bottom: 16px;
        }
        .brand-title em { font-style: normal; color: var(--orange); }

        .brand-desc {
            font-size: 13.5px; color: rgba(255,255,255,0.55);
            line-height: 1.8; max-width: 340px;
        }

        /* Footer */
        .brand-footer { position: relative; z-index: 1; padding-top: 24px; border-top: 1px solid rgba(255,255,255,0.08); }
        .brand-quote { display: flex; gap: 12px; align-items: flex-start; margin-bottom: 14px; }
        .brand-quote-bar { width: 3px; min-height: 40px; border-radius: 2px; background: var(--orange); flex-shrink: 0; }
        .brand-quote-text { font-size: 11.5px; color: rgba(255,255,255,0.4); font-style: italic; line-height: 1.7; }
        .brand-copyright { font-size: 10px; color: rgba(255,255,255,0.2); }

        /* ══ PANNEAU DROIT ══ */
        .form-panel {
            width: 58%; background: white;
            display: flex; align-items: center; justify-content: center;
            padding: 60px 80px;
            position: relative;
        }

        /* Bande couleur en haut */
        .form-panel::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 4px;
            background: linear-gradient(90deg, var(--orange) 0%, var(--vert) 50%, var(--bleu) 100%);
        }

        .form-inner { width: 100%; max-width: 400px; }

        .form-logo { text-align: center; margin-bottom: 36px; }
        .form-logo img { height: 80px; width: auto; object-fit: contain; }

        .form-heading { margin-bottom: 32px; }
        .form-accent { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .form-accent-line { width: 28px; height: 3px; background: var(--orange); border-radius: 2px; }
        .form-accent-text { font-size: 11px; font-weight: 700; color: var(--orange); text-transform: uppercase; letter-spacing: 1.5px; }
        .form-title { font-family: 'Outfit', sans-serif; font-size: 26px; font-weight: 800; color: #1A2E44; margin-bottom: 6px; }
        .form-subtitle { font-size: 13px; color: #9EB0C5; line-height: 1.6; }

        /* Erreur */
        .alert-error {
            display: flex; align-items: center; gap: 10px;
            background: #FFF5F5; border: 1px solid #FED7D7;
            color: #C53030; padding: 12px 16px; border-radius: 10px;
            font-size: 13px; margin-bottom: 20px;
        }
        .alert-error svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }

        /* Champs */
        .form-group { margin-bottom: 18px; }
        .form-label {
            display: flex; align-items: center; justify-content: space-between;
            font-size: 13px; font-weight: 600; color: #2D3748; margin-bottom: 8px;
        }
        .form-label a { font-size: 12px; color: var(--bleu); text-decoration: none; }
        .form-label a:hover { text-decoration: underline; }

        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #CBD5E0; pointer-events: none;
        }
        .input-icon svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 1.8; }
        .form-input {
            width: 100%; padding: 12px 14px 12px 42px;
            border: 1.5px solid #E2E8F0; border-radius: 10px;
            font-size: 14px; font-family: 'Inter', sans-serif;
            color: #2D3748; background: #F7FAFC; outline: none; transition: all 0.18s;
        }
        .form-input:focus { border-color: var(--bleu); background: white; box-shadow: 0 0 0 3px rgba(45,155,214,0.08); }

        /* Remember */
        .remember-row { display: flex; align-items: center; gap: 9px; margin-bottom: 24px; }
        .remember-row input { width: 16px; height: 16px; accent-color: var(--bleu); cursor: pointer; }
        .remember-row label { font-size: 13px; color: #718096; cursor: pointer; }

        /* Bouton */
        .btn-login {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, var(--orange) 0%, #D4792A 100%);
            color: white; border: none; border-radius: 10px;
            font-size: 15px; font-weight: 700; font-family: 'Outfit', sans-serif;
            cursor: pointer; transition: all 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 9px;
            box-shadow: 0 4px 16px rgba(241,151,65,0.35);
            letter-spacing: 0.3px;
        }
        .btn-login:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(241,151,65,0.45); }
        .btn-login svg { width: 18px; height: 18px; stroke: white; fill: none; stroke-width: 2; }

        .form-footer { text-align: center; margin-top: 28px; font-size: 11px; color: #A0AEC0; }

        @media (max-width: 900px) {
            .brand-panel { display: none; }
            .form-panel { width: 100%; padding: 40px 28px; }
        }
    </style>
</head>
<body>
<div class="login-card">

    <!-- PANNEAU GAUCHE -->
    <div class="brand-panel">
        <div class="deco-ring-1"></div>
        <div class="deco-ring-2"></div>

        <div class="brand-logo">
            <img src="{{ asset('images/logo.png') }}" alt="SRM">
            <div class="brand-logo-text">
                <h1>SGAF</h1>
                <p>SRM Casablanca-Settat</p>
            </div>
        </div>

        <div class="brand-content">
            <div class="brand-badge">
                <span></span>
                Système Interne Sécurisé
            </div>
            <div class="brand-title">
                Gestion des<br><em>Achats &</em><br>Fournisseurs
            </div>
            <p class="brand-desc">
                Plateforme centralisée pour piloter l'ensemble du cycle
                d'approvisionnement de la SRM Casablanca-Settat.
            </p>
        </div>

        <div class="brand-footer">
            <div class="brand-quote">
                <div class="brand-quote-bar"></div>
                <div class="brand-quote-text">
                    "Le développement durable est celui qui répond aux besoins des générations présentes sans compromettre les générations futures."
                </div>
            </div>
            <div class="brand-copyright">© {{ date('Y') }} Société Régionale Multiservices Casablanca-Settat SA</div>
        </div>
    </div>

    <!-- PANNEAU DROIT -->
    <div class="form-panel">
        <div class="form-inner">

            <div class="form-logo">
                <img src="{{ asset('images/logo.png') }}" alt="SRM Casablanca-Settat">
            </div>

            <div class="form-heading">
                <div class="form-accent">
                    <div class="form-accent-line"></div>
                    <div class="form-accent-text">Accès Sécurisé</div>
                </div>
                <div class="form-title">Connexion à votre compte</div>
                <div class="form-subtitle">Saisissez vos identifiants pour accéder à l'application SGAF.</div>
            </div>

            @if($errors->any())
            <div class="alert-error">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <div class="form-label"><span>Adresse e-mail</span></div>
                    <div class="input-wrap">
                        <div class="input-icon">
                            <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <input type="email" name="email" id="email" 
                               placeholder="votre@srm-cs.ma" 
                               required 
                               autocomplete="email" 
                               class="form-input"> 
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <span>Mot de passe</span>
                        <a href="#">Mot de passe oublié ?</a>
                    </div>
                    <div class="input-wrap">
                        <div class="input-icon">
                            <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <input type="password" name="password" id="password" 
                               placeholder="••••••••" 
                               required 
                               autocomplete="current-password"
                               class="form-input">
                    </div>
                </div>

                <div class="remember-row">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Se souvenir de moi</label>
                </div>

                <button type="submit" class="btn-login">
                    <svg viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Se connecter
                </button>
            </form>

            <div class="form-footer">
                © {{ date('Y') }} SRM Casablanca-Settat — Application SGAF v1.0
            </div>
        </div>
    </div>

</div>
</body>
</html>