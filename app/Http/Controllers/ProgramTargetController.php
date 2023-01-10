<?php

namespace App\Http\Controllers;

use App\Models\ProgramTargetFileProvinces;
use App\Models\ProgramTargetFiles;
use App\Models\ProgramTargetProvince;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProgramTargetController extends Controller
{
    public function insertTargetReport(Request $request, $programId, $targetId)
    {
        // dd($request->provinces);
        $request->validate([
            "compilation_doc" => ['file'],
            "integration_doc" => ['file'],
            "description" => ['required', 'string'],
            "compilation_target_count" => ['required', 'numeric'],
            "integration_target_count" => ['required', 'numeric'],
            "syncronization_target_count" => ['required', 'numeric'],
            "publication_target_count" => ['required', 'numeric'],
            "provinces" => ['array'],
            "provinces.*" => ['numeric'],
        ]);

        $program = Auth::user()->instance->programs()->where('id', $programId)->first();
        $target = $program->targets()->where('id', $targetId)->first();
        $storage = Storage::disk('local');

        $compilation_doc = '';
        $integration_doc = '';

        if ($request->file('compilation_doc')) {
            $file = $request->file('compilation_doc');

            $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $compilation_doc = (string) Str::uuid() . '.' . $extension;

            $storage->put($compilation_doc, $file);
        }

        if ($request->file('integration_doc')) {
            $file = $request->file('integration_doc');

            $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $integration_doc = (string) Str::uuid() . '.' . $extension;

            $storage->put($integration_doc, $file);
        }

        $targetFiles = $target->files()->create([
            "compilation_doc" => $compilation_doc,
            "integration_doc" => $integration_doc,
            "description" => $request->description,
            "compilation_target_count" => $request->compilation_target_count,
            "integration_target_count" => $request->integration_target_count,
            "syncronization_target_count" => $request->syncronization_target_count,
            "publication_target_count" => $request->publication_target_count,
            "program_target_id" => $target->id
        ]);

        $targetProvince = 0;

        if ($request->provinces) {
            for ($i = 0; $i < count($request->provinces); $i++) {
                $targetProvince = ProgramTargetFileProvinces::create([
                    "province_id" => $request->provinces[$i],
                    "target_file_id" => $targetFiles->id
                ]);
                error_log($targetProvince);
            }
        }


        if ($targetFiles && $targetProvince) {
            return response(["status" => 200, "message" => "Success!"], 200);
        } else {
            return response(["status" => 500, "message" => "Error!"], 500);
        }
    }
}
