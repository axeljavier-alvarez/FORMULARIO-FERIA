<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Solicitud;
use App\Models\Departamento;
use App\Models\Documento;
use App\Models\Estado;
use App\Models\Municipio;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class RegistroForm extends Component
{

// campos del form
public $sobre_mi;
public $nombres;
public $apellidos;
public $email;
public $telefono;
public $dpi;
public $sexo;
public $fechanac;
public $departamentos; 
public $departamento_id;
// public $municipios;
public $municipio_id;
public $zona;
public $documentos;


// GUARDAR VALORES PARA MODAL Y TOKEN QR
public $showModal = false;
public $token = null;

    public function render()
    {
        return view('livewire.registro-form');
    }

    public function mount()
    {
        $this->departamentos = Departamento::orderBy('nombre')->get();
    }

    protected function rules()
    {
        return [
            'sobre_mi'  => 'string|max:1000',
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|max:100',
            'email' => 'required|email',
            'telefono' => 'required|string|min:5',
            'dpi' => 'required|string|max:13',
            'sexo' => 'required|string',
            'fechanac' => 'required|string',
            'departamento_id' => 'required|exists:departamentos,id',
        'municipio_id'    => 'required|exists:municipios,id',
            'zona' => 'string',

        ];
    }

    public function submit()
{
    $this->validate();

    DB::beginTransaction();
    try {

        // Guardar solicitud
        $solicitud = Solicitud::create([
            'sobre_mi' => $this->sobre_mi,
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'dpi' => $this->dpi,
            'sexo' => $this->sexo,
            'fechanac' => $this->fechanac,
            'departamento_id' => $this->departamento_id,
            'municipio_id' => $this->municipio_id,
            'zona' => $this->zona,
            'estado_id' => 1,
            'hash' => Str::uuid()
        ]);

        // CREAR TOKEN PARA ACCESO
        $this->token = Str::random(40);

        // Guardar token en tabla de accesos
        $solicitud->accesos()->create([
            'token' => hash('sha256', $this->token), // guardas hash seguro
            'expires_at' => now()->addDays(7)
        ]);

        DB::commit();

        // Limpiar campos
        $this->reset([
            'sobre_mi',
            'nombres',
            'apellidos',
            'email',
            'telefono',
            'dpi',
            'sexo',
            'fechanac',
            'departamento_id',
            'municipio_id',
            'zona',
        ]);

        // Mostrar modal
        $this->showModal = true;

    } catch (\Throwable $e) {
        DB::rollBack();
        dd([
            'mensaje' => $e->getMessage()
        ]);
    }
}

}
