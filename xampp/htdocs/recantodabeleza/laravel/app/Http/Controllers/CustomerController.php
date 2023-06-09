<?php

namespace App\Http\Controllers;

use App\Models\ModelCustomer;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{

    protected $objCustomer;

    public function __construct() {
        $this->objCustomer = new ModelCustomer();
    }

    public function index() 
    {
        // define a quantidade de registros por pagina
        $customers = $this->objCustomer->paginate(5);
        return view('customers', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('newCustomer');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        if($request->cep != null){
            $cepResponse = cep($request->cep);
            if ($cepResponse->isOk()){
                $data = $cepResponse->getCepModel();
                //return $data;
            } else {
                $errorCEP = "O CEP informado é inválido!";  
            }
        }
        
        $dtNasc = NULL;

        if (isset($request->dtNasc)){
            $dtNasc = explode( '/' , $request->dtNasc);
            $dtNasc = $dtNasc[2] . '-' . $dtNasc[1] . '-' . $dtNasc[0];
        }
        //return $dtNasc;
        
        $data = $request->only('nmCliente', 'sexo', 'telefone', 'email', 'senha', 'rua', 'numero', 'complemento', 'bairro', 'cep', 'rg', 'cidade');
        $data['dtNasc']=$dtNasc;

        if($request->hasFile('foto') && $request->foto->isValid()) {
            $fotoPath = $request->foto->store('customerPhotos');
            $data['foto'] = $fotoPath;
        }

        $this->objCustomer->create($data);
        return redirect($this->objCustomer->whereToGo());
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customers = $this->objCustomer->where('cdCliente', $id)->first();
        
        $novaDtNasc = $this->formatarDtNasc($customers->dtNasc);
        $customers->dtNasc = $novaDtNasc;
        return view('showCustomer', compact('customers'));
    }

    public function formatarDtNasc($dtNasc){
        if ($dtNasc != NULL){
            $dtNasc = explode( '-' , $dtNasc);
            $dtNasc = $dtNasc[2] . '/' . $dtNasc[1] . '/' . $dtNasc[0];
            return $dtNasc;
        } 

        return "";
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cust = $this->objCustomer->where('cdCliente', $id)->first();
        return view('newCustomer', compact('cust'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {
        $cust=$this->objCustomer->where('cdCliente', $id); 
        $cepResponse = cep($request->cep);
        if ($cepResponse->isOk()){
            $data = $cepResponse->getCepModel();
            //return $data;
        } else {
            $errorCEP = "O CEP informado é inválido!";  
        }
        
        $dtNasc = NULL;

        if (isset($request->dtNasc)){
            $dtNasc = explode( '/' , $request->dtNasc);
            $dtNasc = $dtNasc[2] . '-' . $dtNasc[1] . '-' . $dtNasc[0];
        }
        //return $dtNasc;
        
        $data = $request->only('nmCliente', 'sexo', 'telefone', 'email', 'senha', 'rua', 'numero', 'complemento', 'bairro', 'cep', 'rg', 'cidade');
        $data['dtNasc']=$dtNasc;

        if($request->hasFile('foto') && $request->foto->isValid()) {
            $fotoPath = $request->foto->store('customerPhotos');
            $data['foto'] = $fotoPath;
        }

        $cust->update($data);        
        return redirect('adm/customer');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) { // funciona

        $id = $request['cliente_id'];
        $del = $this->objCustomer->where('cdCliente', $id)->delete();

        $customers = $this->objCustomer->paginate(5);

        if($del){
            return view('customers', compact('customers'))
                        ->with(['success'=>'Registro excluído com sucesso!'])->withInput();
        }else{
            return view('customers', compact('customers'))
                        ->with(['errors'=>'Erro ao excluir o registro!'])->withInput();
        }
    }

    protected function getCustomer($id)
    {
        $customer = $this->objCustomer->where('cdCliente', $id)->get();
            if($customer == null){
                throw new Exception('Desculpe, ocorreu um erro ao encontrar o cliente.', 1);
            }
        return $customer;
    }

    public function findCPF($cpf){
        return $this->objCustomer->where('cpf', $cpf)->get();
    }
    
    public function getCPFs(){
        return $this->objCustomer->where('cpf' != NULL)->get(); 
    }

    public function filter(Request $request){    

        $query = $this->objCustomer->query();
        $termos = $request->only(['nmCliente', 'email', 'telefone', 'rg']);

        foreach ($termos as $campo => $valor) {
            if ($valor) { 
                $query->where($campo, 'LIKE', '%' . $valor . '%');
            }
        }
    
        $customers = $query->paginate(5);
        return view('customers', compact('customers'));
    }
}
