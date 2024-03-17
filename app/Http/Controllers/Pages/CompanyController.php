<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(private $prefix, private $uri_prefix, private $extraId, private $uri_suffix, private $pageTitle, private $baseUrl, private $id_name, private $father_url = '')
    {
    }

    function getPermissions($array)
    {
        foreach ($array as $item) {
            if ($item['endpoint'] === $this->prefix) {
                return $item['valor'];
            }

            if (isset($item['sub_permissions'])) {
                $value = $this->getPermissions($item['sub_permissions']);
                if ($value !== null) {
                    return $value;
                }
            }
        }

        return null;
    }

    public function getEndpoint($father_id = '')
    {
        $endpoint = $this->uri_prefix;

        switch ($this->extraId) {
            case 'company':
                $endpoint .= '/' . session('company');
                break;
            case 'emp':
                $endpoint .= '/' . $father_id;
                break;

            default:
                # code...
                break;
        }


        if ($this->uri_suffix != '') {
            $endpoint .= '/' . $this->uri_suffix;
        }
        return $endpoint;
    }

    private $value = null;

    public function getAll()
    {

        if ($this->value === null) {
            $this->value = $this->getPermissions(session('permissions'));
        }
        $data = [
            'pageTitle' => $this->pageTitle,
            'data' => $this->apiRequest($this->getEndpoint(), 'GET', [])['data'],
            'nombre' => '',
            'base_route' => $this->baseUrl,
            'id_name' => $this->id_name,
            'permiso' => $this->value
        ];

        return view($this->baseUrl . '.all', $data);
    }

    public function getOne($id, $failed = false, $father_id = '')
    {
        if ($this->value === null) {
            $this->value = $this->getPermissions(session('permissions'));
        }
        // $value = $this->getPermissions(session('permissions'));
        $data = [
            'pageTitle' => $this->pageTitle,
            'data' => $this->apiRequest($this->getEndpoint($father_id) . '/' . $id, 'GET', [])['data'],
            'failed' => $failed,
            'base_route' => $this->baseUrl,
            'id_name' => $this->id_name,
            'father_id' => $father_id,
            'father_url' => $this->father_url,
            'permiso' => $this->value
        ];

        if ($this->pageTitle == 'Excepciones') {
            $data['empleados'] = $this->apiRequest('companies/' . session('company') . '/employees', 'GET', [])['data'];

            $data['codigos'] = $this->apiRequest('companies/' . session('company') . '/payCodes', 'GET', [])['data'];
        }
        else if ($this->pageTitle == 'Usuarios') {
            $data['roles'] = $this->apiRequest('rols/', 'GET', [])['data'];
            $data['companies'] = $this->apiRequest('companies', 'GET', [])['data'];
        }
        else if ($this->pageTitle == "Documentos"){
            $data['file_path'] = '';
            $mime_type = app('file_types')[$data['data']['tipo']];
            
            list(, $base_64_string) = explode(',', $data['data']['info']);
            $file_data = base64_decode($base_64_string);
            
            $file_name = $data['data']['nombre'] . '.' . app('file_extensions')[$data['data']['tipo']];
            $data['file_name'] = $file_name;

            $file_path = storage_path('app/public/files/' . $file_name);
            file_put_contents($file_path, $file_data);
            
            if( $data['data']['tipo'] < 8){
                $data['file_path'] = $file_path;
            }
            else {
                $data['data']['info'] = 'data:' . $mime_type . ';' . $data['data']['info'];
            }
        }

        return view($this->baseUrl . '.one', $data);
    }

    public function search(Request $request)
    {
        $request->validate([
            'nombre' => 'required | string',
        ]);

        $data = [
            'pageTitle' => $this->pageTitle,
            'data' => $this->apiRequest($this->getEndpoint() . '/' . $request->nombre, 'GET', [])['data'],
            'nombre' => $request->nombre,
            'base_route' => $this->baseUrl,
            'id_name' => $this->id_name,
        ];

        return view($this->baseUrl . '.all', $data);
    }

    public function form($title, $employeesForForm, $father_id = '')
    {
        $data = [
            'pageTitle' => $this->pageTitle,
            'title' => $title,
            'base_route' => $this->baseUrl,
            'empleados' => $employeesForForm ? $this->apiRequest('companies/' . session('company') . '/employees', 'GET', [])['data'] : [],
            'codigos' => $employeesForForm ? $this->apiRequest('companies/' . session('company') . '/payCodes', 'GET', [])['data'] : [],
            'father_id' => $father_id,
            'father_url' => $this->father_url
        ];

        if ($this->pageTitle == 'Usuarios') {
            $data['roles'] = $this->apiRequest('rols/', 'GET', [])['data'];
            $data['companies'] = $this->apiRequest('companies', 'GET', [])['data'];
        }

        return view($this->baseUrl . '.form', $data);
    }

    public function create(Request $request, $validationRules, $changes = [], $father_id = '')
    {
        $request->validate($validationRules);

        $data = $this->UpdateRequest($request, $changes);

        $this->apiRequest($this->getEndpoint($father_id), 'POST', $data);

        return $father_id ? redirect()->route($this->father_url . '.one', ['id' => $father_id]) : redirect()->route($this->baseUrl . '.all');
    }

    public function delete($id, $father_id = '')
    {
        $response = $this->apiRequest($this->getEndpoint($father_id) . '/' . $id, 'DELETE', []);

        if ($response['error']) {
            return $this->getOne($id, true, $father_id);
        } else {
            return $father_id ? redirect()->route($this->father_url . '.one', ['id' => $father_id]) : redirect()->route($this->baseUrl . '.all');
        }
    }

    public function update($id, Request $request, $validationRules, $changes = [], $father_id = '')
    {
        $request->validate($validationRules);

        $data = $this->UpdateRequest($request, $changes);

        $this->apiRequest($this->getEndpoint($father_id) . '/' . $id, 'PUT', $data);

        return $father_id ? redirect()->route($this->baseUrl . '.one', ['id' => $id, 'father_id' => $father_id]) : redirect()->route($this->baseUrl . '.one', ['id' => $id]);
    }
}
