@extends('layouts.form')

@section('inputs')
    <section class="w-full px-8">
        <label class="font-semibold text-lg" for="motivo">Motivo</label>
        <div>
            <textarea class="border-2 border-ldark rounded-lg p-2 w-full mt-2 h-56 resize-none" placeholder="Escriba el motivo del despido" name="motivo"></textarea>
            @if ($errors->has('motivo'))
                <span class="text-danger">{{ $errors->first('motivo') }}</span>
            @endif
        </div>


        <section class=" overflow-x-auto mt-5">
            <table class="table rounded-xl w-full">
                <thead>
                    <tr>
                        <th class="border px-3 py-2 font-semibold">Recontratar</th>
                        <th class="border px-3 py-2 font-semibold">Entrevista</th>
                        <th class="border px-3 py-2 font-semibold">Firma</th>
                        <th class="border px-3 py-2 font-semibold">Finiquito</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border w-32 px-3 py-2">
                            <input type="checkbox" value="8" name="r"
                                class="w-full border rounded-lg p-1">
                        </td>
                        <td class="border w-32 px-3 py-2">
                            <input type="checkbox" value="4" name="e"
                                class="w-full border rounded-lg p-1">
                        </td>
                        <td class="border w-32 px-3 py-2">
                            <input type="checkbox" value="2" name="s"
                                class="w-full border rounded-lg p-1">
                        </td>
                        <td class="border w-32 px-3 py-2">
                            <input type="checkbox" value="1" name="f"
                                class="w-full border rounded-lg p-1">
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </section>
@endsection
