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


public $ruta;

public $captcha_id;

use WithFileUploads;



public function nextStep() {
    $this->validate([
        'nombres' => 'required|string|max:100',
        'apellidos' => 'required|max:100',
        'email' => ['required', 'email', Rule::unique('solicitudes', 'email')],
        'telefono' => 'required|string|min:9|max:9', // Acepta 1234-5678
        'dpi' => ['required', 'string', 'min:13', 'max:15', Rule::unique('solicitudes', 'dpi')], // Acepta espacios
        'sexo' => 'required',
        'fechanac' => 'required',
    ]);

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

        $this->captcha_id = rand();

    }

    public function updatedRuta()
{
    try {
        $this->validateOnly('ruta');
    } catch (ValidationException $e) {
        // Si falla, reseteamos la propiedad para que el input file se limpie
        $this->ruta = null;
        // Lanzamos el error para que Livewire lo capture y lo muestre en el Blade
        throw $e;
    }
}

    protected function messages()
{
    return [
        'ruta.max' => 'El archivo es demasiado grande. El máximo permitido es 2MB.',
        'ruta.mimes' => 'El formato debe ser obligatoriamente un PDF.',
        'ruta.required' => 'Debes adjuntar tu hoja de vida.',
        'ruta.file' => 'El archivo no se cargó correctamente.',
    ];
}
   protected function rules()
{
    return [
        'sobre_mi' => 'nullable|string|max:1000',
        'nombres' => 'required|string|max:100',
        'apellidos' => 'required|max:100',
        'email' => ['required', 'email', Rule::unique('solicitudes', 'email')],
        // Estas reglas deben coincidir con lo que el usuario escribe (con guion y espacios)
        'telefono' => 'required|string|min:9|max:9', 
        'dpi' => ['required', 'string', 'min:13', 'max:15', Rule::unique('solicitudes', 'dpi')],
        'sexo' => 'required|string',
        'fechanac' => 'required|string',
        'departamento_id' => 'required|exists:departamentos,id',
        'municipio_id' => 'required|exists:municipios,id',
        'zona' => 'nullable|string',
        'ruta' => 'required|file|mimes:pdf|max:2048',
    ];
}


// METODO UPDATE QUE SE EJECUTA AUTOMATICAMENTE
// Esto detecta cambios en tiempo real para campos específicos
public function updated($propertyName)
{
    if ($propertyName === 'email' || $propertyName === 'dpi') {
        $this->validateOnly($propertyName, [
            'email' => ['required', 'email', Rule::unique('solicitudes', 'email')],
            'dpi' => ['required', 'string', 'min:13', Rule::unique('solicitudes', 'dpi')],
        ], [
            'email.unique' => 'Este correo ya está registrado en nuestro sistema.',
            'dpi.unique' => 'Este número de DPI ya tiene una solicitud activa.',
        ]);
    }
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

// asegurarse que el telefono lleve +502
// if (!str_starts_with($this->telefono, '+502')) {
//         $this->telefono = '+502' . preg_replace('/\D/', '', $this->telefono);
//  }


// dd([
//         'nombres' => $this->nombres,
//         'telefono' => $this->telefono,
//         'dpi' => $this->dpi,
//         'email' => $this->email,
//         'sexo' => $this->sexo,
//         'fechanac' => $this->fechanac,
//         'municipio_id' => $this->municipio_id,
//         'ruta' => $this->ruta,
//         'captcha' => $this->captcha,
//         'session_captcha' => session('captcha_text')
//     ]);


if (strtoupper($this->captcha) !== session('captcha_text')) {
    throw ValidationException::withMessages([
        'captcha' => 'Datos incorrectos del captcha'
    ]);
}




    // $this->telefono = preg_replace('/\D/', '', $this->telefono); 
    // $this->dpi = preg_replace('/\D/', '', $this->dpi);

        $this->validate();

        // $telefonoParaBD = '+502' . $this->telefono; 
    // $dpiParaBD = $this->dpi;


    DB::beginTransaction();
    try {

    // ARCHIVOS GUARDARLO
    $pathFile = null;
            if ($this->ruta) {
                // Se guarda en storage/app/public/curriculum
                $pathFile = $this->ruta->store('curriculum', 'public');
            }

        // Guardar solicitud
        $solicitud = Solicitud::create([
            'sobre_mi' => $this->sobre_mi,
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'email' => $this->email,
            'telefono'     => $this->telefono,
            'dpi'      => $this->dpi,
            'sexo' => $this->sexo,
            'fechanac' => $this->fechanac,
            // 'departamento_id' => $this->departamento_id,
            'municipio_id' => $this->municipio_id,
            'zona' => $this->zona,
            'ruta' => $pathFile,
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
            'zona',
            'ruta',   
            'captcha'  
        ]);


        $deptoGuate = Departamento::whereRaw('LOWER(nombre) = ?', ['guatemala'])->first();


        if ($deptoGuate) {
            $this->departamento_id = $deptoGuate->id;

            $muniGuate = Municipio::where('departamento_id', $deptoGuate->id)
                ->whereRaw('LOWER(nombre) = ?', ['guatemala'])
                ->first();

            $this->municipios = Municipio::where('departamento_id', $deptoGuate->id)
                ->orderBy('nombre')
                ->get();

            $this->municipio_id = $muniGuate ? $muniGuate->id : null;
        }



          // mostrar el modal si todo sale bien
        $this->showModal = true;
        $this->reloadCaptcha();


        
        // $this->showModal = true;

    } catch (\Throwable $e) {
        DB::rollBack();
        dd([
            'mensaje' => $e->getMessage()
        ]);
    }
}

// REMOVER ARCHIVO ANTES DE ENVIAR FORM
public function removeFile()
    {
        $this->ruta = null;
    }


    public function reloadCaptcha()
{
    $this->captcha = ''; // Limpia el texto quye
    $this->captcha_id = rand(); // Cambia el ID para forzar la recarga de la imagen
    $this->resetErrorBag('captcha'); // Quita el error rojo si existía
}



}
