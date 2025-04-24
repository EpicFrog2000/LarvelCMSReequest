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
        
        
        
        
        //Pobiera dana elementów wyswig z bazy, organizuje je i (TODO) wkłada w templaty
        $viewName = $request->route()->getName();             

        $containers = \App\Models\element_structures::where('view_name', $viewName)->where('type', 'container')->get();
        $containersData = [];
        
        $elements_without_parent = \App\Models\element_structures::where('view_name', $viewName)
            ->where('parentId', '')
            ->where('type', '!=', 'container')
            ->get();
        
        foreach ($containers as $container) {
            $template = '';
            if (!File::exists(public_path('partials/'.$container->dev_name.'.blade.html'))) {
                $template = "BRAK PLIKU TEMPLATE DLA TEGO ELEMENTU";
            } else {
                $template = file_get_contents(public_path('partials/'.$container->dev_name.'.blade.html'));
                foreach ($container->values as $value) {
                    $template = preg_replace('/DEFAULT VALUE/', $value, $template, 1);
                }
                // TODO trzeba będzie inaczej zrobić, czyli włożyć childreny do demplate zamiast values
            }
        
            $containersData[$container->dev_name] = [
                'values' => $container->values,
                'order' => $container->order,
                'template' => $template,
                'children' => [],
                'id' => $container->id,
                'type' => $container->type,
            ];
        
            $currentLevel = \App\Models\element_structures::where('view_name', $viewName)
                ->where('parentId', $container->id)
                ->get();
            $allChildren = [];
            while ($currentLevel->isNotEmpty()) {
                $nextLevel = collect();
                foreach ($currentLevel as $child) {
                    $template = '';
                    if (!File::exists(public_path('partials/'.$child->dev_name.'.blade.html'))) {
                        $template = "BRAK PLIKU TEMPLATE DLA TEGO ELEMENTU";
                    } else {
                        $template = file_get_contents(public_path('partials/'.$child->dev_name.'.blade.html'));
                        foreach ($child->values as $value) {
                            $template = preg_replace('/DEFAULT VALUE/', $value, $template, 1);
                        }
                    }
                    $child['template'] = $template;

                    $allChildren[] = $child;
                    $nextChildren = \App\Models\element_structures::where('view_name', $viewName)
                        ->where('parentId', $child->id)
                        ->get();
                    $nextLevel = $nextLevel->merge($nextChildren);
                }
                $currentLevel = $nextLevel;
            }
        
            $containersData[$container->dev_name]['children'] = $allChildren;
        }
        


        foreach ($elements_without_parent as $element_without_parent) {
            $template = '';
            if (!File::exists(public_path('partials/'.$element_without_parent->dev_name.'.blade.html'))) {
                $template = "BRAK PLIKU TEMPLATE DLA TEGO ELEMENTU";
            } else {
                $template = file_get_contents(public_path('partials/'.$element_without_parent->dev_name.'.blade.html'));
                foreach ($element_without_parent->values as $value) {
                    $template = preg_replace('/DEFAULT VALUE/', $value, $template, 1);
                }
            }
        
            $containerDevName = $element_without_parent->parentId;
        
            if (isset($containersData[$containerDevName])) {
                $containersData[$containerDevName]['children'][] = [
                    'values' => $element_without_parent->values,
                    'order' => $element_without_parent->order,
                    'template' => $template,
                    'id' => $element_without_parent->id,
                    'type' => $element_without_parent->type,
                ];
            } else {
                $containersData['no_container'][] = [
                    'values' => $element_without_parent->values,
                    'order' => $element_without_parent->order,
                    'template' => $template,
                    'id' => $element_without_parent->id,
                    'type' => $element_without_parent->type,
                ];
            }
        }
        
        view()->share('Containers_Data', $containersData);









        //Legacy
        $Element_Structures = \App\Models\element_structures::where('view_name', $viewName)->get();
        $Element_Structure_variables = $Element_Structures->reduce(function ($carry, $Element_Structure) {
            $values = $Element_Structure->values;
            $Template = '';
            if (!File::exists(public_path('partials/'.$Element_Structure->dev_name.'.blade.html'))) {
                $Template = "BLAK PLIKU TEMPLATE DLA TEGO ELEMENTU";
            }else{
                $Template = file_get_contents(public_path('partials/'.$Element_Structure->dev_name.'.blade.html'));
                foreach ($values as $value) {
                    $Template = preg_replace('/DEFAULT VALUE/', $value, $Template, 1);
                }
            }


            $carry[$Element_Structure->dev_name][] = [
                'value' => $Template,
                'id' => $Element_Structure->id
            ];

            return $carry;
        }, []);
        $Element_Structure_variables_original = $Element_Structure_variables;

        view()->share('Element_Structure_variables', $Element_Structure_variables);
        view()->share('Element_Structure_variables_original', $Element_Structure_variables_original);




        return $next($request);
    }

}