<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AdminIndex extends Component
{

    use WithPagination;

    public $pesquisa = '';
    public $situacao = 'ativos';

    public function administradores()
    {
        //filtro por tipo de usuario
        $admins = User::where('tipo', User::TIPO_ADMIN);

        //onlyTrashed retorna somente os excluidos, withTrashed retorna todos.
        if ($this->situacao == 'excluidos') {
            $admins->onlyTrashed();
        } else if ($this->situacao == 'todos') {
            $admins->withTrashed();
        }
        
        $admins->where('nome', 'like', '%'.$this->pesquisa. '%')
        ->orwhere('email', 'like', '%'.$this->pesquisa. '%');

        return $admins->latest()->paginate(10);
    }



    public function render()
    {
        return view('livewire.admin.admin-index')->layout('layout.app', ['title' => 'Administradores', 'admin' => true]);
    }
}
