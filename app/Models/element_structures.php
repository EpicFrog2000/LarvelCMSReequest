<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class element_structures extends Model
{
    protected $table = 'element_structures';
    protected $fillable = [
        'id',
        'parentId',
        'type',
        'order',
        'dev_name',
        'values',
        'view_name',
    ];
    protected $casts = [
        'id' => 'integer',
        'parentId' => 'integer',
        'type' => 'string',
        'order' => 'integer',
        'dev_name' => 'string',
        'values' => 'json',
        'view_name' => 'string',
    ];

    protected function UpdateElement($newValue, $id) {
        $Element_Structure = \App\Models\element_structures::find($id);

        if ($Element_Structure) {
            $Element_Structure->values = $newValue;
            $Element_Structure->save();
        }
    }
    protected function RemoveElement($id){
        $Element_Structure = \App\Models\element_structures::find($id);
        if ($Element_Structure) {
            $Element_Structure->delete();
        }
    }
    protected function AddElement($newValue, $dev_name, $view_name, $parentId, $type, $order) {
        \App\Models\element_structures::create([
            'parentId' => $parentId,
            'type' => $type,
            'order' => $order,
            'values' => $newValue,
            'dev_name' => $dev_name,
            'view_name' => $view_name,
        ]);
    }
}