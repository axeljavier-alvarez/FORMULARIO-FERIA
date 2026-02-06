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
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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
public $municipios = [];

// GUARDAR VALORES PARA MODAL Y TOKEN QR
public $showModal = false;
public $token = null;
public $qrCodeData = null;
public $website;

// PASOS PARA FORMULARIO
public $step = 1;


public $captcha;





public function nextStep() {
    // // Validamos solo los campos del paso 1 antes de avanzar
    // $this->validate([
    //     'nombres' => 'required|string|max:100',
    //     'apellidos' => 'required|max:100',
    //     'email' => 'required|email',
    //     'telefono' => 'required|string|min:5',
    //     'dpi' => 'required|string|max:13',
    //     'sexo' => 'required',
    //     'fechanac' => 'required',
    // ]);
    
    $this->step = 2;
}


public function resetError($field)
{
    $this->resetErrorBag($field);
}



public function prevStep() {
    $this->step = 1;
}

    public function render()
    {
        return view('livewire.registro-form');
    }

    public function mount()
    {

    
        $this->departamentos = Departamento::orderBy('nombre')->get();

        $this->departamento_id = 7;

        $this->municipios = Municipio::where('departamento_id', 7)->get();

        $this->municipio_id = 74;
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

    public function updatedDepartamentoId($id)
    {
        $this->municipios = Municipio::where('departamento_id', $id)
        ->orderBy('nombre')
        ->get();

        // resetear municipio seleccionado si cambia depto
        $this->municipio_id = null;
    }

    public function submit()
{



if (strtoupper($this->captcha) !== session('captcha_text')) {
    throw \Illuminate\Validation\ValidationException::withMessages([
        'captcha' => 'Datos incorrectos del captcha'
    ]);
}


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
            
        ]);

        // CREAR TOKEN PARA ACCESO
        $this->token = Str::random(40);

      


        // $this->qrCodeData = QrCode::size(150)
        //     ->color(0, 0, 0) 
        //     ->margin(1)      
        //     ->generate($this->token)
        //     ->toHtml();

        // guardar token en la bd y seguridad sha256
        $solicitud->accesos()->create([
            'token'      => hash('sha256', $this->token),
            'expires_at' => now()->addDays(30) 
        ]);

        $urlAcceso = route('feria.acceso', ['token' => $this->token]);

        $this->qrCodeData = QrCode::size(200)
        ->color(0,0,0)
        ->margin(1)
        ->generate($urlAcceso)
        ->toHtml();


          DB::commit();
    
          // mostrar el modal si todo sale bien
        $this->showModal = true;

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

       
        $this->showModal = true;

    } catch (\Throwable $e) {
        DB::rollBack();
        dd([
            'mensaje' => $e->getMessage()
        ]);
    }
}

}
