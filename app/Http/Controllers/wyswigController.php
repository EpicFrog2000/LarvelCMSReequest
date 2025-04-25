<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class wyswigController extends Controller
{
    public function getWyswigElement($dev_name)
    {
        return file_get_contents(public_path('partials/'.$dev_name.'.blade.html'));
    }
    public function getWyswigModules(): JsonResponse
    {
        $filenames = collect(File::files(public_path('partials')))
            ->filter(fn($file) => str_contains($file->getFilename(), '.blade.'))
            ->map(fn($file) => preg_replace('/\.blade\..+$/', '', $file->getFilename()))
            ->values();

        return response()->json($filenames);
    }
}
