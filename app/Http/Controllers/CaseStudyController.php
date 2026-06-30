<?php

namespace App\Http\Controllers;

class CaseStudyController extends Controller
{
    public function index()
    {
        return view('case-study.index');
    }

    public function systemIntegration()
    {
        return view('case-study.system-integration');
    }

    public function security()
    {
        return view('case-study.security');
    }

    public function infrastructure()
    {
        return view('case-study.infrastructure');
    }
}
