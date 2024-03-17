<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\HR\Company\General\hr_capacitaciones;
use Illuminate\Http\Request;

class RegistersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $titlepage = '';

    public function getAllContent(){
        $data = [
            'pageTitle' => $this->titlepage,
            'data' => $this->apiRequest('biometrics/registers', 'GET', [])['data']
        ];
        
        return view('biometrics.registros.all', $data);
    }
}