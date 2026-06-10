<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormSubmission;

class FormSubmissionsController extends Controller
{
    public function formSubmissions(Request $request)
    {
        $data = $request->validate([
            'brand_id' => 'required',
            'page_url' => 'nullable|string',
            'form_action' => 'nullable|string',
            'form_method' => 'nullable|string',
            'form_data' => 'nullable|array',
        ]);

        $formSubmission = FormSubmission::create($data);

        $formSubmission->load('brand');

        return response()->json([
            'success' => true,
            'form_submission' => $formSubmission->toArray(),
        ]);
    }
}
