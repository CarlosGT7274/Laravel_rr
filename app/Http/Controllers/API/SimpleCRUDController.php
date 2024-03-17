<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SimpleCRUDController extends Controller
{
    /**
     * Instance of a Model Table
     * @var Model
     */
    private $tableModel;

    /**
     * Create a new controller instance.
     *
     * @param Model $model Model of the table for the instance of the class
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->tableModel = $model;

        $this->middleware('auth:api');
    }

    /**
     * Read All Data from a table with a possible extra param
     * 
     * @param array $extraParam Searching extra param ['column' => one column, 'value' => value of the param]
     * @param boolean $needEncode Bool flag for encode if is needed. 
     * @return array|string Information of All Matching Element
     */
    public function readAll($extraParam, $needEncode = false)
    {
        $data = [];

        if (count($extraParam) == 0) {
            $data = $this->tableModel::all();
        } else {
            $data = $this->tableModel->where($extraParam['column'], $extraParam['value'])->get();
        }

        if ($needEncode) {
            foreach ($data as $object) {
                $object["info"] = "base64," . base64_encode($object["info"]);
            }
        }

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $data
        ], 200);
    }

    /**
     * Read a Specific row on the data base table
     *
     * @param integer $id Element id 
     * @param boolean $needEncode Bool flag for encode if is needed. 
     * @param array $extraParam Searching extra param ['column' => one column, 'value' => value of the param]
     * @param array $extraInfo Extra Info that needs to be add to the response  
     * @return array|string Element Information
     */
    public function readOne($id, $extraParam, $needEncode = false, $extraInfo = [])
    {
        $data = [];

        if (count($extraParam) == 0) {
            $data = $this->tableModel::find($id);
        } else {
            $data = $this->tableModel::where($extraParam['column'], $extraParam['value'])->find($id);
        }

        if (empty($data)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Registro Inexistente'
            ], 404);
        }

        if ($needEncode) {
            $data["info"] = "base64," . base64_encode($data["info"]);
        }

        if (!empty($extraInfo)) {
            foreach ($extraInfo as $key => $value) {
                $data[$key] = $value;
            }
        }

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $data
        ], 200);
    }

    /**
     * Read a Specific row on the data base table by attribute "nombre"
     *
     * @param string $name "nombre" value
     * @param boolean $needEncode Bool flag for encode if is needed. 
     * @param array $extraParam Searching extra param ['column' => one column, 'value' => value of the param]
     * @return array|string Element Information
     */
    public function searchByName($name, $extraParam, $needEncode = false)
    {
        $data = [];

        if (count($extraParam) == 0) {
            $data = $this->tableModel::where('nombre', 'LIKE', '%', $name, '%')->get();
        } else {
            $data = $this->tableModel::where($extraParam['column'], $extraParam['value'])->where(function ($query) use ($name) {
                $query->where('nombre', 'LIKE', '%' . $name . '%');
            })
                ->get();;
        }

        if ($needEncode) {
            $data["info"] = "base64," . base64_encode($data["info"]);
        }

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $data
        ], 200);
    }

    /**
     * Create an new Object on the data base table
     * 
     * @param Request $request JSON of the Request Boy
     * @param array $extraInfo Extra Info for the Element
     * @param array $validationRules Validation Rules for the Request
     * @return boolean
     */
    public function create($request, $extraInfo, $validationRules, $needDecode = false)
    {
        $request->validate($validationRules);

        if (count($extraInfo) > 0) {
            foreach ($extraInfo as $key => $value) {
                $request[$key] = $value;
            }
        }

        if ($needDecode) {
            $request["info"] = base64_decode($request["info"]);
        }

        $object = $this->tableModel::create($request->all());

        if ($needDecode) {
            $object["info"] = "base64," . base64_encode($object["info"]);
        }

        return response()->json([
            'error' => false,
            'mensaje' => '',
            'data' => $object
        ], 201);
    }

    /**
     * Update an object on the data base table
     * 
     * @param int $id Element id 
     * @param Request $request JSON of the Request Boy
     * @param array $validationRules Validation Rules for the Request
     * @param boolean $needEncode Bool flag for encode if is needed. 
     * @return boolean If the Update was successful
     */
    public function update($id, $request, $validationRules, $needDecode = false)
    {
        $object = $this->tableModel::find($id);

        if (empty($object)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Registro Inexistente'
            ], 404);
        }

        $request->validate($validationRules);

        if ($needDecode) {
            $request["info"] = base64_decode($request["info"]);
        }

        //! JUST FOR DEBUG ERRORS
        // try {
        //     $succeed = $object->update($request->all());
        // } catch (\Throwable $th) {
        //     $succeed = false;

        //     return response()->json([
        //         'error' => $succeed ? false : true,
        //         'mensaje' => 'Cambios Realizados'
        //     ], 200);
        // }

        return response()->json([
            'error' => $object->update($request->all()) ? false : true,
            'mensaje' => 'Cambios Realizados'
        ], 200);
    }

    /**
     * Delete a specific object on the data base table.
     * 
     * @param int $id Element id 
     * @return boolean If the Delete was successful
     */
    public function delete($id)
    {
        $object = $this->tableModel::find($id);

        if (empty($object)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Registro Inexistente'
            ], 404);
        }

        try {
            $attempt =  $this->tableModel::destroy($id);
        } catch (\Throwable $th) {
            $attempt = false;

            return response()->json([
                'error' => $attempt ? false : true,
                'id' => $id,
                'mensaje' => $this->tableModel::find($id)
            ], 200);
        }

        return response()->json([
            'error' => $attempt ? false : true,
            'mensaje' => $attempt ? 'Eliminado Correctamente' : 'No se puede borrar el registro'
        ], 200);
    }
}
