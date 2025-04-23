<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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


        $Element_Structures = \App\Models\element_structures::where('view_name', $request->route()->getName())->get();
        $Element_Structure_variables = $Element_Structures->reduce(function ($carry, $Element_Structure) {
            $values = $Element_Structure->values;
            $Template = file_get_contents(public_path('partials/'.$Element_Structure->dev_name.'.blade.html'));
            foreach ($values as $value) {
                $Template = preg_replace('/DEFAULT VALUE/', $value, $Template, 1);
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