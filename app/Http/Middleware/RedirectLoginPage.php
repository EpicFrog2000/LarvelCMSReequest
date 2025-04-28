<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
            ->get();

        $array = [];
        foreach ($onlyContainers as $container) {
            $array[$container->dev_name] = ['children' => Helper::getContainers2($container->id), 'id' => $container->id, 'value' => ''];
        }
       
        Helper::processContainers($array);
        dd($array['container_1']);
        // TODO MERGE TREE
        
        view()->share('Containers_Data', $array);
        
        return $next($request);
    }
}


class Helper{
    public static $viewName = ''; 

    public static function getContainers2($id, )
    {
        $result = [];
        $containerChildren = \App\Models\element_structures::where('view_name', self::$viewName)
            ->where('type', 'container')
            ->where('parentId', $id)
            ->get();

        foreach ($containerChildren as $child) {
            $result[$child->dev_name] = ['children' => self::getContainers2($child->id), 'id' => $child->id, 'value' => ''];
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

public static function processContainers(array &$containers)
{
    foreach ($containers as $devName => &$children) {
        // Najpierw rekurencyjnie przetwarzaj dzieci
        if (!empty($children['children'])) {
            self::processContainers($children['children']);
        }

        // Szablon kontenera
        $children['template'] = self::GetElementsTemplate($devName);
        $children['filled_template'] = $children['template'];

        // Pobranie wartości nie-containerów
        $children['values'] = \App\Models\element_structures::where('view_name', Helper::$viewName)
            ->where('parentId', $children['id'])
            ->where('type', '!=', 'container')
            ->orderBy('order')
            ->get();

        // Jeśli są wartości
        if ($children['values']->isNotEmpty()) {
            foreach (array_reverse($children['values']->all()) as $value) {
                $valueTemplate = self::GetElementsTemplate($value->dev_name);

                // Jeśli $value ma jakieś dane które trzeba zamienić w template
                // (UWAGA: Tu musisz sam zdefiniować jakie pola chcesz wkładać)
                // Zakładam, że każdy $value ma jedno pole np. 'value'
                foreach($value->values as $value){
                    $valueTemplate = preg_replace(
                        '/DEFAULT VALUE/',
                        $value, // <- zmień na odpowiednie pole
                        $valueTemplate,
                        1
                    );
                }


                // Wstawiamy do filled_template kontenera
                $children['filled_template'] = preg_replace(
                    '/DEFAULT VALUE/',
                    $valueTemplate,
                    $children['filled_template'],
                    1
                );
            }

            // Na końcu, jakby jeszcze coś zostało, usuń puste DEFAULT VALUE
            $children['filled_template'] = preg_replace('/DEFAULT VALUE/', '', $children['filled_template']);
        }
    }
}

public static function mergeEverything(array &$container)
{
    if (!empty($container['children'])) {
        foreach ($container['children'] as &$child) {
            self::mergeEverything($child);
            $container['filled_template'] = preg_replace(
                '/DEFAULT VALUE/',
                $child['filled_template'],
                $container['filled_template'],
                1
            );
        }

        // here jeszczer dodaj childreny z tego czyli będzie powyższa funkcja do podziłu

        $container['filled_template'] = preg_replace('/DEFAULT VALUE/', '', $container['filled_template']);
    }
}



}