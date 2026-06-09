<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parametre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ParametreController extends Controller
{
    // Pas de __construct()

    public function index()
    {
        // Vérification manuelle
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Accès non autorisé. Seul l\'administrateur peut accéder aux paramètres.');
        }

        $params = [
            'general' => [
                'app_name' => Parametre::get('app_name', 'TPI Sidi Bennour'),
                'app_email' => Parametre::get('app_email', 'contact@tpi.ma'),
                'app_phone' => Parametre::get('app_phone', '+212 5xxxxxx'),
                'app_address' => Parametre::get('app_address', 'Sidi Bennour, Maroc'),
                'items_per_page' => Parametre::get('items_per_page', 10),
                'date_format' => Parametre::get('date_format', 'd/m/Y'),
            ],
            'securite' => [
                'session_timeout' => Parametre::get('session_timeout', 30),
                'password_expiry' => Parametre::get('password_expiry', 90),
                'max_login_attempts' => Parametre::get('max_login_attempts', 5),
                'two_factor_auth' => Parametre::get('two_factor_auth', false),
            ],
            'notifications' => [
                'email_notifications' => Parametre::get('email_notifications', true),
                'expiration_alert_days' => Parametre::get('expiration_alert_days', 30),
                'inventory_reminder' => Parametre::get('inventory_reminder', true),
            ],
        ];

        return view('parametres.index', compact('params'));
    }

    public function updateGeneral(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_email' => 'required|email',
            'app_phone' => 'nullable|string|max:20',
            'app_address' => 'nullable|string|max:500',
            'items_per_page' => 'required|integer|min:5|max:100',
            'date_format' => 'required|string',
        ]);

        foreach ($validated as $key => $value) {
            Parametre::set($key, $value, 'general');
        }

        return redirect()->route('parametres.index')
            ->with('success', 'Paramètres généraux mis à jour avec succès');
    }

    public function updateSecurite(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $validated = $request->validate([
            'session_timeout' => 'required|integer|min:5|max:480',
            'password_expiry' => 'required|integer|min:30|max:365',
            'max_login_attempts' => 'required|integer|min:3|max:10',
            'two_factor_auth' => 'boolean',
        ]);

        foreach ($validated as $key => $value) {
            Parametre::set($key, $value, 'securite');
        }

        return redirect()->route('parametres.index')
            ->with('success', 'Paramètres de sécurité mis à jour');
    }

    public function updateNotifications(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $validated = $request->validate([
            'email_notifications' => 'boolean',
            'expiration_alert_days' => 'required|integer|min:1|max:90',
            'inventory_reminder' => 'boolean',
        ]);

        foreach ($validated as $key => $value) {
            Parametre::set($key, $value, 'notifications');
        }

        return redirect()->route('parametres.index')
            ->with('success', 'Paramètres de notification mis à jour');
    }

    public function sauvegarde(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $filename = 'sauvegarde_' . date('Y-m-d_H-i-s') . '.sql';
        
        try {
            if (!is_dir(storage_path('backups'))) {
                mkdir(storage_path('backups'), 0755, true);
            }
            
            return redirect()->route('parametres.index')
                ->with('info', 'Sauvegarde en cours de développement');
                
        } catch (\Exception $e) {
            return redirect()->route('parametres.index')
                ->with('error', 'Erreur lors de la sauvegarde');
        }
    }

    public function restaurer(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        return redirect()->route('parametres.index')
            ->with('info', 'Fonctionnalité de restauration en cours de développement');
    }
}