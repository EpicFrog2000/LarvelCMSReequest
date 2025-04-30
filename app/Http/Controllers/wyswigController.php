<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Helper;

class wyswigController extends Controller
{
    public function getWyswigElement($dev_name)
    {
        return file_get_contents(public_path('modules/'.$dev_name.'.blade.html'));
    }
    public function getWyswigModules(): JsonResponse
    {
        $filenames = collect(File::files(public_path('modules/')))
            ->filter(fn($file) => str_contains($file->getFilename(), '.blade.'))
            ->map(fn($file) => preg_replace('/\.blade\..+$/', '', $file->getFilename()))
            ->values();
        return response()->json($filenames);
    }

    public function getWyswigTemplate($dev_name){
        return Helper::GetElementsTemplate($dev_name);
    }
}
