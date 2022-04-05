<?php
namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\Student;

class Crud extends Component
{

    public $students, $codigo, $nombre, $direccion, $telefono, $email;
    public $isModalOpen = 0;

    public function index()
    {
        $this->students = Student::all();
        return view('livewire.crud');
    }
    public function create()
    {
        $this->resetCreateForm();
        $this->openModalPopover();
    }
    public function openModalPopover()
    {
        $this->isModalOpen = true;
    }
    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }
    private function resetCreateForm(){
        $this->nombre = '';
        $this->direccion = '';
        $this->telefono = '';
        $this->email = '';
    }
    
    public function store()
    {
        $this->validate([
            'nombre' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'email' => 'required',
        ]);
    
        Student::updateOrCreate(['id' => $this->codigo], [
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'email' => $this->email,
            
        ]);
        session()->flash('message', $this->codigo ? 'Student updated.' : 'Student created.');
        $this->closeModalPopover();
        $this->resetCreateForm();
    }
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $this->codigo = $id;
        $this->nombre = $student->nombre;
        $this->direccion = $student->direccion;
        $this->telefono = $student->telefono;
        $this->email = $student->email;
        
    
        $this->openModalPopover();
    }
    
    public function delete($id)
    {
        Student::find($id)->delete();
        session()->flash('message', 'Student deleted.');
    }
}