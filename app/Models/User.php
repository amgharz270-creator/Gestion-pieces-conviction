<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; 
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'role_special', 'actif'
    ];

    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['actif' => 'boolean'];

    /**
     * Les rôles spéciaux disponibles
     */
    public static function getRolesSpeciaux()
    {
        return [
            'admin' => [
                'label' => '👑 Administrateur',
                'description' => 'Accès total à tout le système',
                'categories' => ['toutes'],
                'icon' => 'bi-shield-lock-fill'
            ],
            'responsable_argent' => [
                'label' => '💰 Responsable المحجوز النقدي',
                'description' => 'Gère les saisies d\'argent et bijoux',
                'categories' => ['argent', 'bijou'],
                'icon' => 'bi-cash-stack'
            ],
            'responsable_destruction' => [
                'label' => '🔥 Responsable المحجوز للإتلاف',
                'description' => 'Gère les produits à détruire (drogue, armes, liquides)',
                'categories' => ['drogue', 'arme', 'liquide'],
                'icon' => 'bi-fire'
            ],
            'responsable_conservation' => [
                'label' => '📦 Responsable محجوزات يتم الاحتفاظ بها',
                'description' => 'Gère les objets à conserver (documents, électronique, objets, véhicules)',
                'categories' => ['document', 'electronique', 'objet', 'vehicule', 'autre'],
                'icon' => 'bi-archive'
            ],
        ];
    }

    /**
     * Vérifier si l'utilisateur peut voir une catégorie de pièce
     */
    public function peutVoirCategorie($categorie)
    {
        if ($this->role_special == 'admin') {
            return true;
        }
        
        $roleInfo = self::getRolesSpeciaux()[$this->role_special] ?? null;
        if (!$roleInfo) {
            return false;
        }
        
        return in_array($categorie, $roleInfo['categories']) || $roleInfo['categories'][0] == 'toutes';
    }

    /**
     * Récupérer les catégories autorisées pour l'utilisateur
     */
    public function getCategoriesAutorisees()
    {
        if ($this->role_special == 'admin') {
            return ['arme', 'document', 'objet', 'argent', 'drogue', 'vehicule', 'electronique', 'bijou', 'liquide', 'autre'];
        }
        
        $roleInfo = self::getRolesSpeciaux()[$this->role_special] ?? null;
        return $roleInfo ? $roleInfo['categories'] : [];
    }

    /**
     * Libellé du rôle spécial
     */
    public function getRoleSpecialLabel()
    {
        $roles = self::getRolesSpeciaux();
        return $roles[$this->role_special]['label'] ?? $this->role_special;
    }
}