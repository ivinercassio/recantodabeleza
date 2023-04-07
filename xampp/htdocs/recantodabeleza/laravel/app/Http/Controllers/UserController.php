<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\ModelEmployeeType;
use App\Models\ModelEmployee;
use App\Models\ModelClient;
use App\Models\User;

class UserController extends Controller
{
    protected  $objEmployee;
    protected  $objTypeEmp;
    protected  $objClient;
    protected  $objUser;

    public function __construct(){
        $this->objTypeEmp = new ModelEmployeeType;
        $this->objEmployee = new ModelEmployee;
        $this->objClient = new ModelClient;
        $this->objUser = new User;
    }

    public function store($nome, $email, $senha, $tipo) // funcionario ou cliente
    {   
        $this->objUser->name = $nome;
        $this->objUser->email = $email;
        $this->objUser->password = $senha;

        if($tipo != null){ //  caso funcionario

            $employee = $this->objEmployee->where('email', $email)->first();
            $this->objUser->cdFuncionario = $employee->cdFuncionario;

            $this->objUser->save();
            return redirect('adm/employee');

        }else{ // caso cliente

            $cust = $this->objClient->where('email', $email)->first();
            $this->objUser->cdCliente = $cust->cdCliente;

            $this->objuser->save();
            return redirect('adm/customer'); 
        }
    }
        
    public function getCategory(){ // retorna a categoria do usuario logado: funcionario (gerente, vendedor, atendente) ou cliente 
        if(Auth::check()){
            if(Auth::user()->cdFuncionario != null){
                $emp = $this->objEmployee->where('cdFuncionario', Auth::user()->cdFuncionario)->first();
                $tipo = ModelEmployeeType::where('cdTipoFuncionario', $emp->cdTipoFuncionario)->first();
                return $tipo->nmFuncao;
            }else{
                return 'Cliente';
            }
        }
        
    }

}
