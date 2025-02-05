<?php

namespace App\Core;

use Illuminate\Database\Eloquent\Model as Eloquent;

abstract class Model extends Eloquent
{
  
    // Indique si les timestamps doivent être utilisés
    public $timestamps = true;

    // Les attributs qui peuvent être assignés en masse
    protected $fillable = [];

    // Les attributs qui doivent être cachés pour les tableaux
    protected $hidden = [];

     // Obtenir tous les enregistrements
     // \Illuminate\Database\Eloquent\Collection
    public static function getAll()
    {
        return static::all();
    }

    // Trouver data par son ID
    public static function findById($id)
    {
        return static::find($id);
    }

    // Créer un nouvel data
    public static function create(array $attributes = [])
    {
        return static::query()->create($attributes);
    }


    // update un data
    public function updateRecord(array $attributes = [], array $options = [])
    {
        return $this->update($attributes, $options);
    }

    // delete un data
    public function deleteRecord()
    {
        return $this->delete();
    }
}