<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BaseModel;

class TrackingController extends Controller
{
    protected $request;
    protected $modelo;
    protected $modelobase;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->modelobase = new BaseModel();
    }

    function index()
    {
        return view('tracking.index');
    }

    function create()
    {
        $list_base = $this->modelobase->get_list_base_tracking();
        return view('tracking.modal_registrar', compact('list_base'));
    }
}
