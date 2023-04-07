<?php

namespace App\Http\Controllers;

use App\Models\ModelEmployee;
use App\Models\FuncionarioServico;
use App\Http\Requests\ServiceRequest;
use App\Models\ModelService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $objService;
    protected $objEmployee;
    protected $funcionarioServico;

    public function __construct() {
        $this->objService = new ModelService();
        $this->objEmployee = new ModelEmployee();
        $this->funcionarioServico = new FuncionarioServico();
    }

    
    public function index()    {
        $services = $this->objService->paginate(5);
        return view('services', compact('services'));
    }

    public function create()
    {
        try{
            $employees = $this->objEmployee->all();
            return view('newService')->with(compact('employees'));
        }catch(Excepcion $e){
            abort(401, $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        try { 
        $request['valorServico'] = str_replace(',', '.', $request['valorServico']);
        $request['valorServico'] = str_replace(' ', '', $request['valorServico']);
        $servico = $this->objService->create([
            'nmServico' =>$request->nmServico,
            'descricao'=>$request->descricao,
            'valorServico'=>$request->valorServico,
            'comissao'=>($request->comissao/100) 
        ]);
        
        $funcionarios = $request->employee_id;
        //dd($funcionarios);
            if($funcionarios != null) {
                for($i = 0; $i < sizeof($funcionarios); $i++){
                    $servico->relEmployee()->attach($funcionarios[$i]);
                }
            }

         return redirect('adm/service');

        } catch (Exception $e){
            abort(401, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show(Request $request)
    public function show($id)
    {
        $services = $this->objService->where('cdServico', $id)->first();
        
        $rel = $this->funcionarioServico->where('cdServico', $id)->get();
        $rel = $this->menageRelationship($rel);
        
        return view('showService')->with(compact('services'))
                                  ->with(compact('rel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $svc = $this->objService->where('cdServico', $id)->first();
        
        $rel = $this->funcionarioServico->where('cdServico', $id)->get();
        $rel = $this->menageRelationship($rel);
        
        $employees = $this->objEmployee->all();
        $svc->comissao = $svc->comissao*100;
        return view('newService')->with(compact('svc'))
                                 ->with(compact('employees'))
                                 ->with(compact('rel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request, $id)
    {
        $request['valorServico'] = str_replace(',', '.', $request['valorServico']);
        $request['valorServico'] = str_replace(' ', '', $request['valorServico']);
        $this->objService->where('cdServico', $id)->update([
                'nmServico' =>$request->nmServico,
                'descricao'=>$request->descricao,
                'valorServico'=>$request->valorServico,
                'comissao'=>($request->comissao/100)
        ]);
        
        $funcionarios = $request->employee_id;
        // limpar toda a tabela aqui e inserir os registros alterados para serem salvos
        $auxFuncionarios = $funcionarios;
        $del = $this->funcionarioServico->where('cdServico', $id)->delete(); //ok
        for($i = 0; $i < sizeof($auxFuncionarios); $i++){ // referencia nao pode mais ser : $funcionarios
            $this->funcionarioServico->insert([
                'cdServico' => $id, 
                'cdFuncionario' => $auxFuncionarios[$i] 
            ]);
        }
        return redirect('adm/service');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request) {
        
        $id = $request['id'];
        $delFunc = $this->funcionarioServico->where('cdServico', $id)->delete();
        $del = $this->objService->where('cdServico', $id)->delete();

        $services = $this->objService->paginate(5);
        
        if($delFunc && $del){ 
            return view('services', compact('services'))
                                ->withInput(['sucess'=>'Registro excluído com sucesso!']);
        }else{
            return view('services', compact('services'))
                                ->withInput(['errors'=>'Erro ao excluir o registro!']);
        }
    }

    protected function menageRelationship($rel){
        //dd('a');
        if($rel != null){
            //dd('b');
            $return = [];
            foreach($rel as $r){
                $re = new \stdClass();
                $employee = $this->objEmployee->where('cdFuncionario', $r->cdFuncionario)->first();
                $re->cdFuncionario = $employee->cdFuncionario;
                $re->nmFuncionario = $employee->nmFuncionario;

                array_push($return, $re);
            }
            //dd($return);
            return $return;
        }  else {
            throw new \Exception('Desculpe, ocorreu um erro ao recuperar os funcionarios deste servico.');
        }
    }

    public function getEmployeeRelationship(Request $request){
       try {
            $id = $request->get('id');
            $service = $this->objService->where('cdServico', $id)->first();
            if($service == null)
                throw new \Exception('Desculpe, ocorreu um erro ao recuperar os funcionarios deste servico.');

            return $service->relEmployee()->get();
       }catch(Exception $e){
           abort(401, $e->getMessage());
       }

    }

    public function filter(Request $request){   

        $query = $this->objService->query();
        $termos = $request->only(['nmServico', 'valorServico', 'comissao']);

        $termos['valorServico'] = str_replace(',', '.', $request->valorServico);
        $termos['comissao'] = $request->comissao / 100;

        foreach ($termos as $campo => $valor) {
            if ($valor) { 
                $query->where($campo, 'LIKE', '%' . $valor . '%');
            }
        }
    
        $services = $query->paginate(5);
        return view('services', compact('services'));
    }
}
