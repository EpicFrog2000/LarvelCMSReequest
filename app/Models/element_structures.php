<?php
// TODO trzeba będzie zrobić tranzakcjie


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

    protected function UpdateElement($id, $order, $parentId, $dev_name, $view_name){
        try {
            $Element_Structure = \App\Models\element_structures::find($id);
            if ($Element_Structure) {
                if($order){
                    $Element_Structure->order = $order;
                }

                if($parentId){
                    $Element_Structure->parentId = $parentId;
                }

                if($dev_name){
                    $Element_Structure->dev_name = $dev_name;
                }

                if($view_name){
                    $Element_Structure->view_name = $view_name;
                }

                return ['success' => true, 'message' => 'Element updated successfully'];
            }
            return ['success' => false, 'message' => 'Element not found'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Error occurred: ' . $e->getMessage()];
        }
    }

    protected static function RemoveElements($elements){
        try {
            foreach ($elements as $element) {
                $Element_Structure = \App\Models\element_structures::find($element['id']);
                if ($Element_Structure) {
                    $Element_Structure->delete();
                } else {
                    throw new \Exception('Element with ID ' . $element['id'] . ' not found');
                }
            }
            return ['success' => true];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Error occurred: ' . $e->getMessage()];
        }
    }

    protected function AddElement($dev_name, $view_name, $parentId, $type, $order) {
        try {
            \App\Models\element_structures::create([
                'parentId' => $parentId,
                'type' => $type,
                'order' => $order,
                'dev_name' => $dev_name,
                'view_name' => $view_name,
            ]);
            return ['success' => true, 'message' => 'Element added successfully'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Error occurred: ' . $e->getMessage()];
        }
    }

    // TODO przerobić updaty i addy na array a nie pojedyncze
}