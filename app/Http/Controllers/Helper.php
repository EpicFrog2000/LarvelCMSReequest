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
            $array[][$container->dev_name] = ['values' => Helper::getContainers2($container->id), 'id' => $container->id, 'order' => $container->order, 'template' => Helper::GetElementsTemplate($container->dev_name, $container->id), 'filled_template' => '', 'CustomStyleOptions' => $container->CustomStyleOptions];
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
            $result[$child->dev_name] = ['values' => self::getContainers2($child->id), 'id' => $child->id, 'order' => $child->order, 'template' => self::GetElementsTemplate($child->dev_name, $child->id), 'filled_template' => '', 'CustomStyleOptions' => $child->CustomStyleOptions];
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
                        return [$item->id => ['value' => $item->value, 'type' => $item->type, 'CustomStyleOptions' => $item->CustomStyleOptions]];
                    })->toArray();

                $children['values'][] = ['values' => $element_values, 'id' => $value->id, 'order' => $value->order, 'CustomStyleOptions' => $value->CustomStyleOptions, 'template' => Helper::GetElementsTemplate($value->dev_name, $value->id), 'filled_template' => Helper::ZamienWartosciWTemplate(Helper::GetElementsTemplate($value->dev_name, $value->id), $element_values)];
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

    private static function ZamienWartosciWTemplate($template, $values) {
        foreach($values as $key => $value) {
            if ($value['type'] === 'text') {
                // Szukamy konkretnego <wyswigvariable> bez data-id i przypisujemy mu aktualny key
                $template = preg_replace_callback(
                    '/<wyswigvariable(?![^>]*data-id)[^>]*>(.*?)<\/wyswigvariable>/s',
                    function($matches) use ($key, $value) {
                        return "<wyswigvariable data-id=\"{$key}\">" . htmlspecialchars($value['value']) . "</wyswigvariable>";
                    },
                    $template,
                    1
                );
            } else if ($value['type'] === 'media') {
                // Szukamy pierwszego <img> z NoImage.jpg i przypisujemy mu data-id oraz podmieniamy src
                $template = preg_replace_callback(
                    '/<img(?![^>]*data-id)[^>]*src=["\']([^"\']*media\/NoImage\.jpg)["\'][^>]*>/s',
                    function($matches) use ($key, $value) {
                        $src = !empty($value['value']) ? asset($value['value']) : asset('media/NoImage.jpg');
                        $newTag = preg_replace('/src=["\'][^"\']*["\']/', "src=\"{$src}\"", $matches[0]);
                        return preg_replace('/<img/', "<img data-id=\"{$key}\"", $newTag, 1);
                    },
                    $template,
                    1
                );
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

    public static function deleteDirectory($dir) {
        $dir = str_replace('\\', DIRECTORY_SEPARATOR, $dir);
        $items = array_diff(scandir($dir), ['.', '..']);
        
        foreach ($items as $item) {
            $path = $dir . DIRECTORY_SEPARATOR . $item;
            if (is_dir($path)) {
                Helper::deleteDirectory($path);
            } else {
                unlink($path);
            }
        }
        return rmdir($dir);
    }




    // a nie może lepiej najperw dać podził na klasy tych elementów o huj ale to bedzie rozpierdol głowy -_-
    // TODO dodać klasy i ich style do bazy
    // TODO get klasy i ich style z bazy
    // Wpierdolić te klasy do elementów i cssa do stylu view 
}