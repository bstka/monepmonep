<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    public function getAllProgramsByUserInstance()
    {
        $data = Auth::user()->instance->programs()->with(['targets.files', 'targets.files', 'targets.provinces', 'targets.status', 'relatedInstances', 'status'])->get();

        $preResponse = [
            "status" => 200,
            "message" => "Success!",
            "data" => $data
        ];

        return response($preResponse, 200);
    }

    public function getTargetById($programId, $targetId)
    {
        $data = Auth::user()->instance->programs()->where('id', $programId)->with(['instance', 'relatedInstances', 'unit'])->first();
        $target = $data->targets()->where('id', $targetId)->with(['files', 'files.provinces'])->first();

        $preResponse = [
            "status" => 200,
            "message" => "Success!",
            "data" => [
                "program" => $data,
                "target" => $target
            ]
        ];

        return response($preResponse, 200);
    }
}
