<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SwitchSave;
use Illuminate\Http\Request;

class SwitchSaveController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'fname'    => 'required|string|max:255',
            'email'    => 'required|email',
            'msisdn'   => 'required',
            'simno'    => 'required',
            'plan'     => 'required',
            'cat'      => 'required',
            'ospno'    => 'required',
            'osppass'  => 'required',
            'addr1'    => 'required',
            'addr2'    => 'required',
            'city'     => 'required',
            'state'    => 'required',
            'zip'      => 'required',
            'concent'  => 'boolean',
            'terms'    => 'boolean',
        ]);

        $record = SwitchSave::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data saved successfully',
            'data'    => $record,
        ]);
    }
}
