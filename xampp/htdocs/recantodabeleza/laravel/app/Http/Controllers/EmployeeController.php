<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use App\Models\FuncionarioServico;
use App\Models\ModelService;
use App\Models\ModelEmployee;
use App\Models\ModelEmployeeType; 
use App\Models\User;

class EmployeeController extends Controller
{

    protected  $objEmployee;
    protected  $objEmployeeType;
    protected  $objService;
    protected  $objUser;
    protected  $funcionarioServico;

    public function __construct(){
        $this->objEmployee = new ModelEmployee();
        $this->objEmployeeType = new ModelEmployeeType();
        $this->objService = new ModelService();
        $this->objUser = new User;
    }

    public function search(Request $request)
    {
        $term = $request->get('term');
        $employees = $this->objEmployee->where('nmFuncionario', 'like', '%' . $term . '%')->get();
        return $employees;
    }

    public function index()
    {
        $employees = $this->objEmployee->paginate(5);
        $etypes = $this->objEmployeeType->all();

        return view('employees', compact('employees'), compact('etypes'));
    }

    public function create()
    {
        $etypes = $this->objEmployeeType->all();
        return view('newEmployee', compact('etypes'));
    }

    public function store(EmployeeRequest $request)
    {   
        $cepResponse = cep($request->cep);
        if ($cepResponse->isOk()){
            $data = $cepResponse->getCepModel();
        } else {
            $errorCEP = "O CEP informado é inválido!";  
            $etypes = $this->objEmployeeType->all();
            return view('newEmployee', compact('errorCEP'), compact('etypes'));
        }
        
        $dtNasc = NULL;

        if (isset($request->dtNasc)){
            $dtNasc = explode( '/' , $request->dtNasc);
            $dtNasc = $dtNasc[2] . '-' . $dtNasc[1] . '-' . $dtNasc[0];
        }

        if ($this->objEmployee->create([
            'nmFuncionario' => $request->nome,
            'sexo' => $request->sexo,
            'dtNasc' => $dtNasc,
            'cpf' => $request->cpf,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'senha' => $request->senha,
            'numero' => $request->numero,
            'cep' => $data->cep, 
            'rua' => $data->logradouro,
            'bairro' => $data->bairro,
            'cidade' => $data->localidade,
            'complemento' => $request->complemento ?? NULL,
            'cdTipoFuncionario' => $request->tipo
            ])){        
                $emp = $this->objEmployee->where('email', $request->email)->first(); 

                return redirect()->route('newUser', [
                    "nome"=> $emp->nmFuncionario, 
                    "email"=> $emp->email, 
                    "senha"=> bcrypt($emp->senha), // criptografando a senha
                    "tipo"=> $emp->cdTipoFuncionario ?? NULL
                ]); 
            } 
    }

    public function show($id)
    {
        $emp = $this->objEmployee->where('cdFuncionario', $id)->first();
        return view('showEmployee', compact('emp'));
    }

    public function edit($id)
    {
        $emp = $this->objEmployee->where('cdFuncionario', $id)->first();
        $etypes = $this->objEmployeeType->all();
        return view('newEmployee', compact('etypes'), compact('emp'));
    }
  
    public function update(EmployeeRequest $request, $id)
    {
        $cepResponse = cep($request->cep);
        if ($cepResponse->isOk()){
            $data = $cepResponse->getCepModel();
        } else {
            $errorCEP = "O CEP informado é inválido!";  
            $etypes = $this->objEmployeeType->all();
            return view('newEmployee', compact('errorCEP'), compact('etypes'));
        }
        
        $dtNasc = NULL;

        if (isset($request->dtNasc)){
            $dtNasc = explode( '/' , $request->dtNasc);
            $dtNasc = $dtNasc[2] . '-' . $dtNasc[1] . '-' . $dtNasc[0];
        }

        if ($this->objEmployee->where('cdFuncionario', $id)->update([
            'nmFuncionario' => $request->nome,
            'sexo' => $request->sexo,
            'dtNasc' => $dtNasc,
            'cpf' => $request->cpf,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'senha' => $request->senha,
            'numero' => $request->numero,
            'cep' => $request->cep,
            'rua' => $request->logradouro,
            'bairro' => $request->bairro,
            'cidade' => $data->localidade,
            'complemento' => $request->complemento ?? NULL,
            'cdTipoFuncionario' => $request->tipo
        ])){

            if ($this->objUser->where('cdFuncionario', $id)->update([
                'name' => $request->nome,
                // 'email' => $request->email, // email pode ser alterado?
                'password' => bcrypt($request->senha) // criptografando a senha
            ])){
                return redirect('adm/employee');
            }
        }
    }

    public function destroy(Request $request) {

        $id = $request['id'];
        $delUsuario = $this->objUser->where('cdFuncionario', $id)->delete();
        $del = $this->objEmployee->where('cdFuncionario', $id)->delete();

        $employees = $this->objEmployee->paginate(5);
        $etypes = $this->objEmployeeType->all();

        if($del  && $delUsuario){
            return view('employees', compact('employees'), compact('etypes'))
                    ->withInput(['sucess'=>'Registro excluído com sucesso!']);
        }else{
            return view('employees', compact('employees'), compact('etypes'))
                    ->withInput(['errors'=>'Erro ao excluir o registro!']);
        }
    }

    public function getCPFs(){
        return $this->objEmployee->whereNotNull('cpf')->get(); 
    }

    public function getEmails(){
        return $this->objEmployee->whereNotNull('email')->get(); 
    }

    public function filter(Request $request){   

        $etypes = $this->objEmployeeType->all();
        $query = $this->objEmployee->query();
        $termos = $request->only(['nmFuncionario', 'email', 'cpf', 'telefone']);

        foreach ($termos as $campo => $valor) {
            if ($valor) { 
                $query->where($campo, 'LIKE', '%' . $valor . '%');
            }
        }

        $employees = $query->paginate(5);
        return view('employees', compact('employees'), compact('etypes'));
    }    
}
