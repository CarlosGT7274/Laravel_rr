<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Create a new controller instance.
     *
     * @param string $uri Api uri where the request should be made
     * @param string $method Method for the api request
     * @param array $params for the body of the request to the api
     * @return array
     */
    public function apiRequest($uri, $method, $params)
    {
        $internalRequest = Request::create('/api/' . env('API_VERSION') . '/' . $uri, $method, $params, [], [], $_SERVER);

        $internalRequest->headers->set('Authorization', 'Bearer ' . session('token'));

        // $internalRequest = Request::createFromBase(request());

        // $internalRequest->server->set('REQUEST_URI', '/api/' . env('API_VERSION') . '/' . $uri);

        // $internalRequest->setMethod($method);

        // $internalRequest->merge($params);

        // $internalRequest->headers->set('Authorization', 'Bearer ' . session('token'));

        $response = app()->handle($internalRequest);


        if ($response->getStatusCode() == 500) {
            return ['error' => true, 'mensaje' => 'Error en el Servidor'];
            // return $response;
        } else {
            $data = json_decode($response->getContent(), true);
            $data['code'] = $response->getStatusCode();
            return $data;
        }
    }

    public function UpdateRequest(Request $request, $changes)
    {
        $data = [];

        $todosLosDatos = array_merge($request->all(), $request->allFiles());

        foreach ($todosLosDatos as $llave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $key => $value) {
                    $data[$llave][$key] = $value;

                    foreach ($value as $sub_key => $sub_value) {
                        if (array_key_exists($sub_key, $changes)) {
                            if ($changes[$sub_key] == 'int' && $sub_value) {
                                $data[$llave][$key][$sub_key] = (int) $sub_value;
                            } else if ($changes[$sub_key] == 'float' && $sub_value) {
                                $data[$llave][$key][$sub_key] = (float) $sub_value;
                            } else if ($changes[$sub_key] == 'datetime') {
                                $data[$llave][$key][$sub_key] = str_replace('T', ' ', $sub_value);
                            } else {
                                $data[$llave][$key][$changes[$sub_key]] = $sub_value;
                                unset($data[$llave][$key][$sub_key]);
                            }
                        }
                    }
                }
            } else {
                if (array_key_exists($llave, $changes)) {
                    if ($changes[$llave] == 'int' && $valor) {
                        $data[$llave] = (int) $valor;
                    } else if ($changes[$llave] == 'float' && $valor) {
                        $data[$llave] = (float) $valor;
                    } else if ($changes[$llave] == 'datetime') {
                        $data[$llave] = str_replace('T', ' ', $valor);
                    } else if ($changes[$llave] == 'file') {
                        $data[$llave] = base64_encode(file_get_contents($request->file($llave)->path()));
                        $data['tipo'] = $this->findFileExtension($request->file($llave)->getMimeType());
                    } else {
                        $data[$changes[$llave]] = $valor;
                    }
                    unset($changes[$llave]);
                } else {
                    $data[$llave] = $valor;
                }
            }
        }

        if (!empty($changes)) {
            foreach ($data as $llave => $valor) {

                if (is_array($valor)) {
                    foreach ($valor as $key => $value) {
                        foreach ($value as $sub_key => $sub_value) {
                            if (array_key_exists($sub_key, $changes)) {
                                if ($changes[$sub_key] == 'int' && $sub_value) {
                                    $data[$llave][$key][$sub_key] = (int) $sub_value;
                                } else if ($changes[$sub_key] == 'float' && $sub_value) {
                                    $data[$llave][$key][$sub_key] = (float) $sub_value;
                                } else if ($changes[$sub_key] == 'datetime') {
                                    $data[$llave][$key][$sub_key] = str_replace('T', ' ', $sub_value);
                                }
                            }
                        }
                    }
                } else {
                    if (array_key_exists($llave, $changes)) {
                        if ($changes[$llave] == 'int' && $valor) {
                            $data[$llave] = (int) $valor;
                        } else if ($changes[$llave] == 'float' && $valor) {
                            $data[$llave] = (float) $valor;
                        } else if ($changes[$llave] == 'file') {
                            $data[$llave] = base64_encode(file_get_contents($valor->path()));
                            $data['tipo'] = $this->findFileExtension($valor->getMimeType());
                        } else if ($changes[$llave] == 'datetime') {
                            $data[$llave] = str_replace('T', ' ', $valor);
                        }
                    }
                }
            }
        }
        return $data;
    }

    public function findFileExtension($file_type)
    {
        $index = array_search($file_type, app('file_types'));
        return $index;
    }
}
