<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class element_values extends Model
{
    protected $table = 'element_values';
    protected $fillable = [
        'id',
        'parentId',
        'order',
        'CustomStyleOptions',
        'type',
        'view_name',
        'value',
    ];
    protected $casts = [
        'id' => 'integer',
        'parentId' => 'integer',
        'order' => 'integer',
        'CustomStyleOptions' => 'json',
        'type' => 'string',
        'view_name' => 'string',
        'value' => 'string',
    ];

    protected function UpdateElement($newValue, $id) {
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
    protected function AddElement() {
        dd('NOT IMPLEMENTED');
    }
}