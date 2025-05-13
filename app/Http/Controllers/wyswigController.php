<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Helper;

class wyswigController
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
        $template = '';
        if (!File::exists(public_path('modules/' . $dev_name . '.blade.html'))) {
            $template = "BRAK PLIKU TEMPLATE DLA TEGO ELEMENTU";
        } else {
            $template = file_get_contents(public_path('modules/' . $dev_name . '.blade.html'));
        }

        return $template;
    }

    public function getFilesAndFolders($path){
        return Helper::getFilesAndFolders($path);
    }

}
