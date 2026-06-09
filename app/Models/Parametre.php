<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parametre extends Model
{
    protected $fillable = ['cle', 'valeur', 'type', 'groupe'];

    public static function get($cle, $default = null)
    {
        $param = self::where('cle', $cle)->first();
        return $param ? $param->valeur : $default;
    }

    public static function set($cle, $valeur, $groupe = 'general')
    {
        return self::updateOrCreate(
            ['cle' => $cle],
            ['valeur' => $valeur, 'groupe' => $groupe]
        );
    }
}