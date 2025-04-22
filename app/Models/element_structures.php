<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class element_structures extends Model
{
    protected $table = 'element_structures';
    protected $fillable = [
        'dev_name',
        'default_value',
        'value',
        'view_name',
    ];
    protected $casts = [
        'dev_name' => 'string',
        'default_value' => 'string',
        'value' => 'string',
        'view_name' => 'string',
    ];

protected static function UpdateElement($newValue, $id) {
    $Element_Structure = \App\Models\element_structures::find($id);

    if ($Element_Structure) {
        $Element_Structure->value = $newValue;
        $Element_Structure->save();
    }
}
    protected function RemoveElement($id){
        $Element_Structure = \App\Models\element_structures::find($id);
        if ($Element_Structure) {
            $Element_Structure->delete();
        }
    }
    protected function AddElement($newValue, $id){
        //TODO DOKONCZYC
        $Element_Structure = new \App\Models\element_structures();
        $Element_Structure->value = $newValue;
        $Element_Structure->save();

    }
}