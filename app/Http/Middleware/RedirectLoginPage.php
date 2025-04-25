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

        $containers = \App\Models\element_structures::where('view_name', $viewName)->where('type', 'container')->get();
        $containersData = [];
    
        
        foreach ($containers as $container) {        
            $container->values = Helper::GetContainersChildrenPopulatedTemplates($container, $viewName);
        
            $containersData[$container->dev_name] = Helper::GetContainersTemplatePopulatedWithValues($container);
        }
        
        view()->share('Containers_Data', $containersData);


        // //Legacy
        // $Element_Structures = \App\Models\element_structures::where('view_name', $viewName)->get();

        // $Element_Structure_variables = [];

        // foreach ($Element_Structures as $Element_Structure) {
        //     $Element_Structure_variables[$Element_Structure->dev_name][] = [
        //         'value' => Helper::GetElementsTemplatePopulatedWithValues($Element_Structure),
        //         'id' => $Element_Structure->id
        //     ];
        // }
        // $Element_Structure_variables_original = $Element_Structure_variables;

        // view()->share('Element_Structure_variables', $Element_Structure_variables);
        // view()->share('Element_Structure_variables_original', $Element_Structure_variables_original);
        return $next($request);
    }
}


class Helper{
    public static function GetElementsTemplatePopulatedWithValues($Element){
        $Template = '';
        if (!File::exists(public_path('partials/' . $Element->dev_name . '.blade.html'))) {
            $Template = "BLAK PLIKU TEMPLATE DLA TEGO ELEMENTU";
        } else {
            $Template = file_get_contents(public_path('partials/' . $Element->dev_name . '.blade.html'));
            if ($Element->values) {
                foreach ($Element->values as $value) {
                    $Template = preg_replace('/DEFAULT VALUE/', $value, $Template, 1);
                }
            }
        }
        return $Template;
    }

    public static function GetContainersTemplatePopulatedWithValues($container){
        $template = '';
        if (!File::exists(public_path('partials/'.$container->dev_name.'.blade.html'))) {
            $template = "BRAK PLIKU TEMPLATE DLA TEGO ELEMENTU";
        } else {
            $template = file_get_contents(public_path('partials/'.$container->dev_name.'.blade.html'));
            if($container->values){
                foreach (array_reverse($container->values) as $value) {
                    $template = preg_replace('/DEFAULT VALUE/', 'DEFAULT VALUE' . $value, $template, 1);
                }
                $template = preg_replace('/DEFAULT VALUE/', '', $template, 1);
            }
        }
        return $template;
    }




    public static function GetContainersChildrenPopulatedTemplates($container, $viewName){
        $currentLevel = \App\Models\element_structures::where('view_name', $viewName)
            ->where('parentId', $container->id)
            ->orderBy('order')
            ->get();
        
        $allChildren = [];
        while ($currentLevel->isNotEmpty()) {
            $nextLevel = collect();
            foreach ($currentLevel as $child) {
                $nextChildren = \App\Models\element_structures::where('view_name', $viewName)
                    ->where('parentId', $child->id)
                    ->orderBy('order')
                    ->get();
                $allChildren[] = Helper::GetElementsTemplatePopulatedWithValues($child);
                $nextLevel = $nextLevel->merge($nextChildren);
            }
            $currentLevel = $nextLevel;
        }
        return $allChildren;
    }





}