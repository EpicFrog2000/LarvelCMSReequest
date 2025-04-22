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
            $value = empty($Element_Structure->value) ? $Element_Structure->default_value : $Element_Structure->value;
            $carry[$Element_Structure->dev_name][] = [
                'value' => $value,
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