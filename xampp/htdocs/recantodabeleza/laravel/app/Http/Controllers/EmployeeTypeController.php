<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EmployeeTypeRequest;
use App\Models\ModelEmployeeType;

class EmployeeTypeController extends Controller
{

    protected  $objEmployeeType;

    public function __construct(){
        $this->objEmployeeType = new ModelEmployeeType();
    }
    public function index()
    {
        $etypes = $this->objEmployeeType->paginate(5);
        return view('employeeTypes', compact('etypes'));
    }

    public function create()
    { 
        return view('newEmployeeType');
    }

    public function store(EmployeeTypeRequest $request)
    {   
        $salario = str_replace(' ', '', $request->salarioBase);
        $salario = str_replace(',', '.', $salario);
        
        if ($this->objEmployeeType->create([
            'nmFuncao' => $request->nomeFuncao,
            'salarioBase' => $salario
            ])){
                return redirect($this->objEmployeeType->whereToGo()); 
            } 
    }

    public function show($id)
    {
        $etype = $this->objEmployeeType->where('cdTipoFuncionario', $id)->first();
        return view('showEmployeeType', compact('etype'));
    }

    public function edit($id)
    {
        $etype = $this->objEmployeeType->where('cdTipoFuncionario', $id)->first();
        return view('newEmployeeType', compact('etype'));
    }
  
    public function update(EmployeeTypeRequest $request, $id)
    {
        $salario = str_replace(' ', '', $request->salarioBase);
        $salario = str_replace(',', '.', $salario);

        if ($this->objEmployeeType->where('cdTipoFuncionario', $id)->update([
            'nmFuncao' => $request->nomeFuncao,
            'salarioBase' => $salario
            ])){
                return redirect('adm/employeeType');
            } 
    }
  
    public function destroy(Request $request)
    {
        $id = $request['id'];
        $del = $this->objEmployeeType->where('cdTipoFuncionario', $id)->delete();

        $etypes = $this->objEmployeeType->paginate(5);

        if($del){
            return view('employeeTypes', compact('etypes'))
                                            ->withInput(['sucess'=>'Registro excluído com sucesso!']);
        }else{
            return view('employeeTypes', compact('etypes'))
                                            ->withInput(['errors'=>'Erro ao excluir o registro!']);
        }
    }

    public function filter(Request $request){   

        $query = $this->objEmployeeType->query();
        $termos = $request->only(['nmFuncao', 'salarioBase']);

        $termos['salarioBase'] = str_replace(',', '.', $request->salarioBase);

        foreach ($termos as $campo => $valor) {
            if ($valor) { 
                $query->where($campo, 'LIKE', '%' . $valor . '%');
            }
        }
    
        $etypes = $query->paginate(5);
        return view('employeeTypes', compact('etypes'));
    }
  
}
