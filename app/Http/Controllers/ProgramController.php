<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    public function getAllProgramsByUserInstance()
    {
        $data = Auth::user()->instance->programs()
            ->with([
                'targets.files', 'targets.provinces',
                'targets.status', 'relatedInstances', 'status'
            ])
            ->get();

        $preResponse = [
            "status" => 200,
            "message" => "Success!",
            "data" => $data
        ];

        return response($preResponse, 200);
    }

    public function getTargetById($programId, $targetId)
    {
        $data = Auth::user()->instance->programs()
            ->where('id', $programId)
            ->with(['instance', 'relatedInstances', 'unit'])
            ->first();

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

    public function getAllProgramsByUserInstanceAndYear($year, $stepId, $subStepId)
    {
        $data = Auth::user()->instance->programs()->where('step_id', $stepId)->where('sub_step_id', $subStepId)
            ->with([
                'targets' => function ($query) use ($year) {
                    return $query->whereIn('year', [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, $year]);
                }, 'targets.files',
                'targets.provinces', 'targets.status',
                'relatedInstances', 'status'
            ])->get();

        // $data = Auth::user()->instance->programs()->where('step_id', $stepId)->with(['targets' => function ($q) {
        //     $q->whereIn('year', [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 2022]);
        // }, 'targets.files', 'targets.provinces', 'targets.status', 'relatedInstances', 'status'])->get();

        // dd($data);

        $preResponse = [
            "status" => 200,
            "message" => "Success!",
            "data" => $data
        ];

        return response($preResponse, 200);
    }
}
