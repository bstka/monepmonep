<?php

namespace App\Http\Controllers;

use App\Models\ProgramTargetFileProvinces;
use App\Models\ProgramTargetFiles;
use App\Models\ProgramTargetProvince;
use Carbon\Carbon;
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
            "compilation_doc" => ['file', 'required'],
            "integration_doc" => ['file'],
            "description" => ['required', 'string'],
            "compilation_target_count" => ['numeric'],
            "integration_target_count" => ['numeric'],
            "syncronization_target_count" => ['numeric'],
            "publication_target_count" => ['numeric'],
            "provinces" => ['array'],
            "provinces.*" => ['numeric'],
        ]);

        $program = Auth::user()->instance->programs()->where('id', $programId)->first();
        $target = $program->targets()->where('id', $targetId)->first();
        $storage = Storage::disk('local');

        // ! Target Valueization / Grading!
        $targetQuantitive = $program->quantitive;

        $compilationValue = (int) (intval($request->compilation_target_count) / intval($targetQuantitive)) * 100;
        $integrationValue = (int) (intval($request->integration_target_count) / intval($targetQuantitive)) * 100;
        $publicationValue = (int) (intval($request->publication_target_count) / intval($targetQuantitive)) * 100;
        $syncronizationValue = (int) (intval($request->syncronization_target_count) / intval($targetQuantitive)) * 100;

        $compilation_doc = null;
        $integration_doc = null;

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
            "publication_target_count" => $request->publication_target_count,
            "syncronization_target_count" => $request->syncronization_target_count,
            "compilation_value" => $compilationValue,
            "integration_value" => $integrationValue,
            "publication_value" => $publicationValue,
            "syncronization_value" => $syncronizationValue,
            "program_target_id" => $target->id,
            "reported_by_user_id" => Auth::user()->id,
        ]);

        $targetProvince = 0;

        if ($request->provinces) {
            for ($i = 0; $i < count($request->provinces); $i++) {
                $targetProvince = ProgramTargetFileProvinces::create([
                    "province_id" => $request->provinces[$i],
                    "target_file_id" => $targetFiles->id
                ]);
            }
        }


        if ($targetFiles && $targetProvince) {
            return response(["status" => 200, "message" => "Success!"], 200);
        } else {
            return response(["status" => 500, "message" => "Error!"], 500);
        }
    }

    public function deleteTargetReport($programId, $targetId, $fileId)
    {
        $data = Auth::user()->instance->programs()->where('id', $programId)->first();
        $target = $data->targets()->where('id', $targetId)->first();
        $file = $target->files()->where('id', $fileId)->delete();

        if ($file) {
            return response(["status" => 200, "message" => "Success!"], 200);
        } else {
            return response(["status" => 500, "message" => "Error!"], 500);
        }
    }

    public function updateTargetReport(Request $request, $programId, $targetId, $fileId)
    {
        $request->validate([
            "compilation_doc" => ['file'],
            "integration_doc" => ['file'],
            "description" => ['string'],
            "compilation_target_count" => ['numeric'],
            "integration_target_count" => ['numeric'],
            "syncronization_target_count" => ['numeric'],
            "publication_target_count" => ['numeric'],
            "provinces" => ['array'],
            "provinces.*" => ['numeric'],
        ]);

        $data = Auth::user()->instance->programs()->where('id', $programId)->first();
        $target = $data->targets()->where('id', $targetId)->first();
        $storage = Storage::disk('local');

        $preInsertData = [
            "description" => $request->description,
            "compilation_target_count" => $request->compilation_target_count,
            "integration_target_count" => $request->integration_target_count,
            "publication_target_count" => $request->publication_target_count,
            "syncronization_target_count" => $request->syncronization_target_count,
        ];

        if ($request->file('compilation_doc')) {
            $file = $request->file('compilation_doc');

            $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $compilation_doc = (string) Str::uuid() . '.' . $extension;
            $preInsertData['compilation_doc'] = $compilation_doc;

            $storage->put($compilation_doc, $file);
        }

        if ($request->file('integration_doc')) {
            $file = $request->file('integration_doc');

            $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $integration_doc = (string) Str::uuid() . '.' . $extension;
            $preInsertData['integration_doc'] = $integration_doc;

            $storage->put($integration_doc, $file);
        }

        $file = $target->files()->where('id', $fileId)->first();

        if ($request->provinces) {
            if (count($file->provinces) > 0) ProgramTargetFileProvinces::where("target_file_id", $fileId)->delete();

            for ($i = 0; $i < count($request->provinces); $i++) {
                $targetProvince = ProgramTargetFileProvinces::create([
                    "province_id" => $request->provinces[$i],
                    "target_file_id" => $fileId
                ]);
            }
        }

        $fileUpdate = $file->update($preInsertData);

        if ($fileUpdate > 0) {
            return response(["status" => 200, "message" => "Success!"], 200);
        } else {
            return response(["status" => 500, "message" => "Error!"], 500);
        }
    }

    public function validateTargetReport(Request $request, $fileId)
    {
        $request->validate([
            "verificationNote" => ['string']
        ]);

        $data = null;

        if (Auth::user()->hasRole(['setkab'])) {
            $data = ProgramTargetFiles::where('id', $fileId)->update([
                "validated_by_setkab_id" => Auth::user()->id,
                "validate_note_setkab" => $request->verificationNote,
                "validated_by_setkab_timestamp" => Carbon::now('Asia/Jakarta')
            ]);
        } else if (Auth::user()->hasRole(['satgas'])) {
            $data = ProgramTargetFiles::where('id', $fileId)->update([
                "validated_by_satgas_id" => Auth::user()->id,
                "validate_note_satgas" => $request->verificationNote,
                "validated_by_satgas_timestamp" => Carbon::now('Asia/Jakarta')
            ]);
        } else {
            return response(["status" => 403, "message" => "Unauthorized"], 403);
        }

        if ($data !== null) {
            return response(["status" => 200, "message" => "Success!"], 200);
        } else {
            return response(["status" => 500, "message" => "Error!"], 500);
        }
    }

    public function unvalidateTargetReport(Request $request, $fileId)
    {
        $request->validate([
            "verificationNote" => ['string']
        ]);

        $data = null;

        if (Auth::user()->hasRole(['setkab'])) {
            $data = ProgramTargetFiles::where('id', $fileId)->update([
                "validated_by_setkab_id" => null,
                "validate_note_setkab" => null,
                "validated_by_setkab_timestamp" => null
            ]);
        } else if (Auth::user()->hasRole(['satgas'])) {
            $data = ProgramTargetFiles::where('id', $fileId)->update([
                "validated_by_satgas_id" => null,
                "validate_note_satgas" => null,
                "validated_by_satgas_timestamp" => null
            ]);
        } else {
            return response(["status" => 403, "message" => "Unauthorized"], 403);
        }

        if ($data !== null) {
            return response(["status" => 200, "message" => "Success!"], 200);
        } else {
            return response(["status" => 500, "message" => "Error!"], 500);
        }
    }
}
