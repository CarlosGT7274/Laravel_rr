<?php

return [
    'required' => 'Falta el campo :attribute.',
    'string' => 'El campo :attribute debe ser una cadena de texto.',
    'email' => 'El campo :attribute debe ser una dirección de correo electrónico válida.',
    'array' => 'El campo :attribute debe ser un arreglo o verifica si no necesitas atributos.',
    'integer' => 'El campo :attribute debe ser un número entero.',
    'file' => 'El campo :attribute debe ser un archivo.',
    'mimes' => 'El archivo debe ser de uno de los siguientes tipos: :values.',
    'decimal' => [
        'numeric' => 'El campo :attribute debe ser un número decimal con :decimal lugares decimales.',
    ],
    'exists' => 'El valor seleccionado en el campo :attribute no es válido.',
    'min' => [
        'numeric' => 'El campo :attribute debe ser al menos :min.',
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
    'max' => [
        'numeric' => 'El campo :attribute no debe ser mayor que :max.',
        'string' => 'El campo :attribute no debe tener más de :max caracteres.',
    ],
    'size' => [
        'numeric' => 'El campo :attribute debe ser :size.',
        'string' => 'El campo :attribute debe tener :size caracteres.',
    ],
    'required_if' => 'El campo :attribute es obligatorio cuando :other es :value.',
    'sometimes' => 'El campo :attribute es requerido.',
    'between' => [
        'numeric' => 'El campo :attribute debe estar entre :min y :max.',
        'string' => 'El campo :attribute debe tener entre :min y :max caracteres.',
    ],
    'nullable' => 'El campo :attribute puede ser nulo.',
    'regex' => 'El formato del campo :attribute es inválido.',
    'date' => 'El campo :attribute no es una fecha válida.',
    'date_format' => 'El campo :attribute no coincide con el formato :format.',
    'after_or_equal' => 'La fecha :attribute debe ser después del campo :date',
    'required_without' => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_with' => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all' => 'El campo :attribute es obligatorio cuando :values están presentes.',
    'same' => 'El campo debe ser igual a :other',
];
