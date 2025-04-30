<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;


class Helper{
    private static $viewName = '';



    public static function getViewElements($viewName){
        self::$viewName = $viewName; // głupie ale wyjebane na razie może kiedyś zmienie xd
        $onlyContainers = \App\Models\element_structures::where('view_name', $viewName)
        ->where('type', 'container')
        ->whereNull('parentId')
        ->orderBy('order')
        ->get();

        $array = [];
        foreach ($onlyContainers as $container) {
            $array[$container->dev_name] = ['values' => Helper::getContainers2($container->id), 'id' => $container->id, 'order' => $container->order, 'template' => Helper::GetElementsTemplate($container->dev_name), 'filled_template' => ''];
        }
        Helper::GetContainerValues($array);
        Helper::mergeEverything($array);
        return $array;
    }

    public static function getSiteSettings(){
        $settings = \App\Models\site_settings::get();
        $SiteSettings = [];
        foreach ($settings as $setting) {
            $SiteSettings[$setting->nazwa] = $setting->value;
        }
        return $SiteSettings;
    }


    public static function GetElementsTemplate($dev_name){
        $template = '';
        if (!File::exists(public_path('modules/' . $dev_name . '.blade.html'))) {
            $template = "BRAK PLIKU TEMPLATE DLA TEGO ELEMENTU";
        } else {
            $template = file_get_contents(public_path('modules/' . $dev_name . '.blade.html'));
        }
        return $template;
    }


    private static function getContainers2($id)
    {
        $result = [];
        $containerChildren = \App\Models\element_structures::where('view_name', self::$viewName)
            ->where('type', 'container')
            ->where('parentId', $id)
            ->orderBy('order')
            ->get();
        foreach ($containerChildren as $child) {
            $result[$child->dev_name] = ['values' => self::getContainers2($child->id), 'id' => $child->id, 'order' => $child->order, 'template' => self::GetElementsTemplate($child->dev_name), 'filled_template' => ''];
        }
        return $result;
    }


    private static function GetContainerValues(&$containers)
    {
        foreach ($containers as $devName => &$children) {
            if (!empty($children['values'])) {
                Helper::GetContainerValues($children['values']);
            }

            $new_values = \App\Models\element_structures::where('view_name', Helper::$viewName)
                ->where('parentId', $children['id'])
                ->where('type', '!=', 'container')
                ->orderBy('order')
                ->get();

            foreach($new_values as $value){
                $children['values'][] = ['values' => $value->values, 'id' => $value->id, 'order' => $value->order, 'template' => Helper::GetElementsTemplate($value->dev_name), 'filled_template' => Helper::ZamienWartosciWTemplate(Helper::GetElementsTemplate($value->dev_name), $value->values)];
            }
            usort($children['values'], function ($a, $b) {
                return $a['order'] <=> $b['order'];
            });
        }
    }

    private static function mergeEverything(array &$containers)
    {
        foreach ($containers as $devName => &$container) {
            if (!empty($container['values'])) {
                self::mergeEverything($container['values']);
            }

            if(isset($container['id'])){
                if($container['filled_template'] == ""){
                    //dd($container['template']);
                    $container['filled_template'] = $container['template'];
                    if (!empty($container['values'])) {
                        foreach ($container['values'] as $value) {
                            Helper::DodajWartoscDoTemplate($container['filled_template'], $value['filled_template']);
                        }
                        Helper::removeDefaultsFromTemplateContainers($container['filled_template']);
                    }
                }
            }
        }
    }

    private static function ZamienWartosciWTemplate($template, $values){
        foreach($values as $value){
            $template = preg_replace('/DEFAULT VALUE/', $value, $template, 1);
        }
        return $template;
    }
    
    private static function DodajWartoscDoTemplate(&$template, $value){
        $template = str_replace('DEFAULT VALUE', $value.'DEFAULT VALUE', $template);
    }

    private static function removeDefaultsFromTemplateContainers(&$template) {
        $template = preg_replace('/<\/wyswigElement>\s*DEFAULT VALUE/', '</wyswigElement>', $template);
        $template = preg_replace('/<\/wyswigContainer>\s*DEFAULT VALUE/', '</wyswigContainer>', $template);
    }
}