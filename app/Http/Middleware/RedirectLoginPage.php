<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Nette\Schema\Elements\Type;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\File;


class RedirectLoginPage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('login')) {
            return redirect()->route('adminlogin.form');
        }
        if ($request->has('logout')) {
            session(['_auth' => false]);
            session()->save();
            return redirect()->route('home');;
        }


        $settings = \App\Models\site_settings::get();
        $SiteSettings = [];
        foreach ($settings as $setting) {
            $SiteSettings[$setting->nazwa] = $setting->value;
        }
        view()->share('Site_Settings', $SiteSettings);
        
        
        //TODO ORDER ELELEMTY
        //TODO WYŚIWETL DOSTĘPNE MODUŁY
        
        //Pobiera dana elementów wyswig z bazy, organizuje je i (TODO) wkłada w templaty
        $viewName = $request->route()->getName();             
        Helper::$viewName = $viewName;

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
        
        //Helper::SortContainerValues($array);
        dd($array);
        Helper::mergeEverything($array);
        dd($array);
        Helper::removeDefaultsFromTemplateContainers($array['container_1']['filled_template']);
        
        view()->share('Containers_Data', $array);
        
        return $next($request);
    }
}


class Helper{
    public static $viewName = ''; 

    public static function getContainers2($id)
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

    public static function GetElementsTemplate($dev_name){
        $template = '';
        if (!File::exists(public_path('partials/' . $dev_name . '.blade.html'))) {
            $template = "BRAK PLIKU TEMPLATE DLA TEGO ELEMENTU";
        } else {
            $template = file_get_contents(public_path('partials/' . $dev_name . '.blade.html'));
        }
        return $template;
    }

    public static function GetContainerValues(&$containers)
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



    public static function mergeEverything(array &$containers)
    {
        foreach ($containers as $devName => &$container) {

            if (!empty($container['values'])) {
                self::mergeEverything($container['values']);
            }

            if(isset($container['id'])){
                dd($container);
            }
            // pomysl moze pojdz po !"filled_template"
            // if (!empty($container['values'])) {
            //     foreach ($container['values'] as &$child) {
            //         $container['filled_template'] = preg_replace(
            //             '/DEFAULT VALUE/',
            //             $child['filled_template'],
            //             $container['filled_template'],
            //             1
            //         );
            //     }
            //     $container['filled_template'] = preg_replace('/DEFAULT VALUE/', '', $container['filled_template']);
            // }
        }
    }


    public static function ZamienWartosciWTemplate($template, $values){
        foreach($values as $value){
            $template = preg_replace('/DEFAULT VALUE/', $value, $template, 1);
        }
        return $template;
    }
    
    public static function DodajWartoscDoTemplate(&$template, $value){
        $template = str_replace('DEFAULT VALUE', $value.'DEFAULT VALUE', $template);
    }

    
    public static function removeDefaultsFromTemplateContainers(&$template) {
        $template = preg_replace('/<\/wyswigElement>\s*DEFAULT VALUE/', '</wyswigElement>', $template);
        $template = preg_replace('/<\/wyswigContainer>\s*DEFAULT VALUE/', '</wyswigContainer>', $template);
    }

}