<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;


class Helper{
    private static $viewName = '';

    //TODO dodać do tego custom style options z bazy
    //TODO zamiast małych zapytań do bazy zrobić jedno duże zapytanie i potem to jakoś ogarnąć

    public static function getViewElements($viewName){
        self::$viewName = $viewName; // głupie ale wyjebane na razie może kiedyś zmienie xd
        $onlyContainers = \App\Models\element_structures::where('view_name', $viewName)
        ->where('type', 'container')
        ->whereNull('parentId')
        ->orderBy('order')
        ->get();

        $array = [];
        foreach ($onlyContainers as $container) {
            $array[][$container->dev_name] = ['values' => Helper::getContainers2($container->id), 'id' => $container->id, 'order' => $container->order, 'template' => Helper::GetElementsTemplate($container->dev_name, $container->id), 'filled_template' => ''];
        }

        foreach ($array as $key => &$value) {

            Helper::GetContainerValues($value);
            Helper::mergeEverything($value);
        }
        
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


    public static function GetElementsTemplate($dev_name, $id){
        $template = '';
        if (!File::exists(public_path('modules/' . $dev_name . '.blade.html'))) {
            $template = "BRAK PLIKU TEMPLATE DLA TEGO ELEMENTU";
        } else {
            $template = file_get_contents(public_path('modules/' . $dev_name . '.blade.html'));
        }

        if (strpos($template, 'wyswigElement') !== false) {
            $template = preg_replace('/<wyswigElement.*?/s', "<wyswigElement data-id=\"{$id}\"", $template);
        } elseif (strpos($template, 'wyswigContainer') !== false) {
            $template = preg_replace('/<wyswigContainer.*?/s', "<wyswigContainer data-id=\"{$id}\"", $template);
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
            $result[$child->dev_name] = ['values' => self::getContainers2($child->id), 'id' => $child->id, 'order' => $child->order, 'template' => self::GetElementsTemplate($child->dev_name, $child->id), 'filled_template' => ''];
        }
        return $result;
    }


    private static function GetContainerValues(&$containers)
    {
        foreach ($containers as $devName => &$children) {
            $element_values = \App\Models\element_values::where('view_name', Helper::$viewName)
                ->where('parentId',  $children['id'])
                ->orderBy('order')->get()->toArray();

            if (empty($element_values)) {
                Helper::GetContainerValues($children['values']);
            }

            $new_values = \App\Models\element_structures::where('view_name', Helper::$viewName)
                ->where('parentId', $children['id'])
                ->where('type', '!=', 'container')
                ->orderBy('order')
                ->get();

            foreach($new_values as $value){
                $element_values = \App\Models\element_values::where('view_name', Helper::$viewName)
                    ->where('parentId',  $value->id)
                    ->orderBy('order')->get()->mapWithKeys(function ($item) {
                        return [$item->id => ['value' => $item->value, 'type' => $item->type]];
                    })->toArray();

                $children['values'][] = ['values' => $element_values, 'id' => $value->id, 'order' => $value->order, 'template' => Helper::GetElementsTemplate($value->dev_name, $value->id), 'filled_template' => Helper::ZamienWartosciWTemplate(Helper::GetElementsTemplate($value->dev_name, $value->id), $element_values)];
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
                    $container['filled_template'] = $container['template'];
                    if (!empty($container['values'])) {
                        foreach ($container['values'] as $value) {
                            Helper::DodajWartoscDoTemplate($container['filled_template'], $value['filled_template']);
                        }
                    }
                    Helper::removeDefaultsFromTemplateContainers($container['filled_template']);
                }
            }
        }
    }

    private static function ZamienWartosciWTemplate($template, $values){
        foreach($values as $key => $value){
            
            if($value['type'] == 'text'){
                $template = preg_replace('/<wyswigvariable.*?/s', "<wyswigvariable data-id=\"{$key}\"", $template);
                $template = preg_replace('/DEFAULT VALUE/', $value['value'], $template, 1);
            }else if($value['type'] == 'media'){
                $template = preg_replace('/>/', "data-id=\"{$key}\">", $template);
                if(!empty($value['value'])){
                    $template = preg_replace('/media\/NoImage\.jpg/', asset($value['value']), $template, 1);
                }else{
                    $template = preg_replace('/media\/NoImage\.jpg/', asset('media/NoImage.jpg'), $template, 1);
                }
            }
        }
        return $template;
    }


    
    private static function DodajWartoscDoTemplate(&$template, $value){
        $template = str_replace('DEFAULT VALUE', $value.'DEFAULT VALUE', $template);
    }

    private static function removeDefaultsFromTemplateContainers(&$template) {
        $template = preg_replace('/DEFAULT VALUE\s*<\/wyswigElement>/', '</wyswigElement>', $template);
        $template = preg_replace('/DEFAULT VALUE\s*<\/wyswigContainer>/', '</wyswigContainer>', $template);
    }

    
    public static function getFilesAndFolders($path) {
        $result = ['folders' => [], 'files' => []];

        if (is_dir($path)) {
            $items = scandir($path);

            foreach ($items as $item) {
                if ($item !== '.' && $item !== '..') {
                    if (is_dir($path . DIRECTORY_SEPARATOR . $item)) {
                        $result['folders'][] = ['foldername' => $item, 'path' => asset($path . DIRECTORY_SEPARATOR . $item. DIRECTORY_SEPARATOR)];
                    } else {
                        $result['files'][] = ['filename' => $item, 'path' => asset($path. DIRECTORY_SEPARATOR . $item)];
                    }
                }
            }
        }

        return response()->json($result);
    }

    public static function RemoveFile($filePath){

    }

    public static function AddFile($location, $fileName){

    }

    public static function AddFolder($location, $folderName){

    }
    public static function RemoveFolder($location, $folderName){

    }
}