<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Alumno;
use App\Models\Asistencia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Alumnos extends Component {
    public $alumnos, $nombre, $edad, $grupo, $asistencia, $id_alumno;
    public $modal = false, $asis = false, $fecha;
    protected $rules = [
            'nombre' => 'required|min:2',
            'edad' => 'required|integer|numeric',
            'grupo' => 'required',
    ];
    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }
    public function render() {
        $this->fecha = Carbon::now();
        $this->alumnos = DB::table('alumnos')->orderBy('nombre')->get();
        return view('livewire.alumnos');
    }
    public function crear() {
        $this->limpiarCampos();
        $this->abrirModal();
    }
    public function abrirModal() {
        $this->modal = true;
    }
    public function cerrarModal() {
        $this->modal = false;
    }
    public function abrirModal2() {
        $this->asis = true;
    }
    public function cerrarModal2() {
        $this->asis = false;
    }
    public function limpiarCampos() {
        $this->nombre = '';
        $this->edad = '';
        $this->grupo = '';
    }
    public function editar($id) {
        $alumno = Alumno::findOrFail($id);
        $this->id_alumno = $id;
        $this->nombre = $alumno->nombre;
        $this->edad = $alumno->edad;
        $this->grupo = $alumno->grupo;
        $this->abrirModal();
    }
    public function asistencia($id) {
        $alumno = Alumno::findOrFail($id);
        $this->id_alumno = $id;
        $this->nombre = $alumno->nombre;
        $this->abrirModal2();
    }
    public function borrar($id) {
        Alumno::find($id)->delete();
        session()->flash('message', 'Registro eliminado correctamente');
    }
    public function guardar() {
        $this->validate();
        Alumno::updateOrCreate(['id'=>$this->id_alumno],
            [
                'nombre' => $this->nombre,
                'edad' => $this->edad,
                'grupo' => $this->grupo,
            ]);
        session()->flash('message',
           $this->id_alumno ? '¡Actualización exitosa!' : '¡Alta Exitosa!');
        $this->cerrarModal();
        $this->limpiarCampos();
    }
    public function guardarAsistencia() {
        Asistencia::Create([
                'fk_alumno' => $this->id_alumno,
                'dia' => $this->fecha,
        ]);
        session()->flash('message', '¡Asistencia confirmada!');
        $this->cerrarModal2();
        $this->limpiarCampos();
    }
}