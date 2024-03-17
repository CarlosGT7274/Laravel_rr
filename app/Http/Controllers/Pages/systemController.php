<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class systemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $pageTitle = '';

    public function getAll()
    {
        $data = [
            'pageTitle' => $this->pageTitle,
            'data' => $this->apiRequest('rols', 'GET', [])['data'],
            'permiso' => session('permissions')[5]['sub_permissions'][501]['valor']
        ];

        return view('system.roles.all', $data);
    }

    public function getOne($id, $failed = '')
    {
        $data = [
            'pageTitle' => $this->pageTitle,
            'data' => $this->apiRequest('rols' . '/' . $id, 'GET', [])['data'],
            'permisosG' => $this->apiRequest('privileges', 'GET', [])['data'],
            'delete' => $failed,
            'permiso' => session('permissions')[5]['sub_permissions'][501]['valor']
        ];

        return view('system.roles.one', $data);
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'nombre' => 'sometimes | required | string'
        // ]);

        $result = [
            'nombre' => $request['Nrol'],
            'permisos' => [],
        ];

        foreach ($request['permisos'] as $permiso) {
            $permiso_value = -1; // Valor predeterminado a -1
            $id_permiso = $permiso['id_permiso'];

            if (in_array(15, $permiso)) {
                $permiso_value = 15;
            } elseif (in_array(-1, $permiso)) {
                $permiso_value = -1;
            } else {
                unset($permiso['id_permiso']);
                // dd($permiso);
                $numeric_values = [];

                if (isset($permiso['todos'])) {
                    $permiso['todos'] = 15;
                    $numeric_values[] = $permiso['todos'];
                } else {
                    if (isset($permiso['off'])) {
                        $permiso['off'] = -1;
                        $numeric_values[] = $permiso['off'];
                    }

                    if (isset($permiso['on'])) {
                        $permiso['on'] = 0;
                        $numeric_values[] = $permiso['on'];
                    }

                    if (isset($permiso['r'])) {
                        $permiso['r'] = 1;
                        $numeric_values[] = $permiso['r'];
                    }

                    if (isset($permiso['c'])) {
                        $permiso['c'] = 2;
                        $numeric_values[] = $permiso['c'];
                    }

                    if (isset($permiso['u'])) {
                        $permiso['u'] = 4;
                        $numeric_values[] = $permiso['u'];
                    }

                    if (isset($permiso['d'])) {
                        $permiso['d'] = 8;
                        $numeric_values[] = $permiso['d'];
                    }
                }


                if (!empty($numeric_values)) {
                    $permiso_value = array_sum($numeric_values);
                }
            }

            $result['permisos'][] = [
                'id_permiso' => (int) $id_permiso,
                'permiso' => $permiso_value,
            ];
        }

        $this->apiRequest('rols' . '/' . $id, 'PUT', $result);

        return redirect()->route('rol.one', ['id' => $id]);
    }

    public function form()
    {
        $data = [
            'pageTitle' => $this->pageTitle,
            'data' => $this->apiRequest('rols', 'GET', [])['data'],
            'permisosG' => $this->apiRequest('privileges', 'GET', [])['data'],
            'permiso' => session('permissions')[5]['sub_permissions'][501]['valor']
        ];

        return view('system.roles.form', $data);
    }

    public function create(Request $request)
    {
        $result = [
            'nombre' => $request['Nrol'],
            'permisos' => [],
        ];

        foreach ($request['permisos'] as $permiso) {
            $permiso_value = -1;
            $id_permiso = $permiso['id_permiso'];

            if (in_array(15, $permiso)) {
                $permiso_value = 15;
            } elseif (in_array(-1, $permiso)) {
                $permiso_value = -1;
            } else {
                unset($permiso['id_permiso']);
                // dd($permiso);
                $numeric_values = [];

                if (isset($permiso['todos'])) {
                    $permiso['todos'] = 15;
                    $numeric_values[] = $permiso['todos'];
                } else {
                    if (isset($permiso['off'])) {
                        $permiso['off'] = -1;
                        $numeric_values[] = $permiso['off'];
                    }

                    if (isset($permiso['on'])) {
                        $permiso['on'] = 0;
                        $numeric_values[] = $permiso['on'];
                    }

                    if (isset($permiso['r'])) {
                        $permiso['r'] = 1;
                        $numeric_values[] = $permiso['r'];
                    }

                    if (isset($permiso['c'])) {
                        $permiso['c'] = 2;
                        $numeric_values[] = $permiso['c'];
                    }

                    if (isset($permiso['u'])) {
                        $permiso['u'] = 4;
                        $numeric_values[] = $permiso['u'];
                    }

                    if (isset($permiso['d'])) {
                        $permiso['d'] = 8;
                        $numeric_values[] = $permiso['d'];
                    }
                }


                if (!empty($numeric_values)) {
                    $permiso_value = array_sum($numeric_values);
                }
            }

            $result['permisos'][] = [
                'id_permiso' => (int) $id_permiso,
                'permiso' => $permiso_value,
            ];
        }

        $this->apiRequest('rols', 'POST', $result);

        return redirect()->route('rol.all');
    }

    public function delete($id)
    {
        $delete = $this->apiRequest('rols' . '/' . $id, 'DELETE', []);

        if ($delete['error'] == true) {
            return $this->getOne($id, $delete['mensaje']);
        } else {
            return redirect()->route('rol.all');
        }
    }
}
