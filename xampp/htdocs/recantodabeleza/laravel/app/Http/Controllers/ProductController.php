<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FornecedorProduto;
use App\Models\ModelSupplier;
use App\Http\Requests\ProductRequest;
use App\Models\ModelProduct;
use Illuminate\Support\Facades\Storage;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected  $objSupplier;
    protected  $objProduct;
    protected  $fornecedorProduto;
    
    public function __construct() {
        $this->objSupplier = new ModelSupplier();
        $this->objProduct = new ModelProduct();
        $this->fornecedorProduto = new FornecedorProduto();
    }

    public function index()
    {
        $products = $this->objProduct->paginate(5);
        return view('products', compact('products'));
    }

    public function indexProducts(Request $request)
    {
        $valor = 5 + $request->valor;
        var_dump($valor);
        $products = $this->objProduct->paginate($valor);
        return view('products', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('newProduct');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $request['precoProduto'] = str_replace(',', '.', $request['precoProduto']);
        $request['precoProduto'] = str_replace(' ', '', $request['precoProduto']);

        $data = $request->only('nmProduto', 'marca', 'descricao', 'qtd', 'precoProduto', 'comissao');

        if($request->hasFile('foto') && $request->foto->isValid()) {
            $fotoPath = $request->foto->store('productPhotos');
            $data['foto'] = $fotoPath;
        }
        $this->objProduct->create($data);
        return redirect('adm/product');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $products = $this->objProduct->where('cdProduto', $id)->first();
        return view ('showProduct', compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prod=$this->objProduct->where('cdProduto', $id)->first();
        return view('newProduct', compact('prod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $prod=$this->objProduct->where('cdProduto', $id);
        
        $request['precoProduto'] = str_replace(',', '.', $request['precoProduto']);
        $request['precoProduto'] = str_replace(' ', '', $request['precoProduto']);
        // $foto=DB::table('TbProduto')->select('foto')->where('cdProduto', $id)->get();        
        $data = $request->only('nmProduto', 'marca', 'descricao', 'qtd', 'precoProduto', 'comissao');
        
        if($request->hasFile('foto') && $request->foto->isValid()) {   
            $fotoPath = $request->foto->store('productPhotos');
            $data['foto'] = $fotoPath;
        }

        $prod->update($data);
        return redirect('adm/product');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) { 

        $id = $request['id'];
        $del = $this->objProduct->where('cdProduto', $id)->delete();

        $products = $this->objProduct->paginate(5);

        if($del){ 
            return view('products', compact('products'))
                        ->withInput(['sucess'=>'Registro excluído com sucesso!']);
        }else{
            return view('products', compact('products'))
                        ->withInput(['errors'=>'Erro ao excluir o registro!']);
        }
    }

    public function filter(Request $request){   

        $query = $this->objProduct->query();
        $termos = $request->only(['nmProduto', 'marca', 'precoProduto', 'comissao']);

        $termos['precoProduto'] = str_replace(',', '.', $request->precoProduto);

        foreach ($termos as $campo => $valor) {
            if ($valor) { 
                $query->where($campo, 'LIKE', '%' . $valor . '%');
            }
        }
    
        $products = $query->paginate(5);
        return view('products', compact('products'));
    }

    public function exibirRegistrosProducts(Request $request){
        var_dump($request->valor);
    }

}
