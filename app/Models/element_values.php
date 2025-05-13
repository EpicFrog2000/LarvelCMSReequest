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

    protected function UpdateElement($newValue, $id, $parentId, $type, $view_name) {
        try {
            $Element_Structure = \App\Models\element_values::find($id);
            if ($Element_Structure) {
                if($newValue){
                    $Element_Structure->value = $newValue;
                }
                if($parentId){
                    $Element_Structure->parentId = $parentId;
                }
                if($type){
                    $Element_Structure->type = $type;
                }
                if($view_name){
                    $Element_Structure->view_name = $view_name;
                }
                
                $Element_Structure->save();
            }
            return ['success' => true, 'message' => 'Element added successfully'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Error occurred: ' . $e->getMessage()];
        }
    }
    protected function RemoveElement($id){
        $Element_Structure = \App\Models\element_values::find($id);
        if ($Element_Structure) {
            $Element_Structure->delete();
        }
    }
    protected function AddElement($parentId, $order, $type, $view_name, $value) {
        try {
            \App\Models\element_values::create([
                'parentId' => $parentId,
                'type' => $type,
                'order' => $order,
                'view_name' => $view_name,
                'value' => $value,
            ]);
            return ['success' => true, 'message' => 'Element added successfully'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Error occurred: ' . $e->getMessage()];
        }
    }
}