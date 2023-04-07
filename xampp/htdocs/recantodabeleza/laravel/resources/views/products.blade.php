@extends('templates.adm')

@section('title') Produtos @endsection('title')

@section('icon') <img class='responsive' src='{{url("/img/icons/product.png")}}' width='35px'> @endsection('icon')

@section('content')

<script src='{{url("/assets/js/jquery.quicksearch.js")}}'></script>
<script src='{{url("/assets/js/jquery.tablesorter.min.js")}}'></script>
<meta name="csrf-token_post" content="{{ csrf_token() }}">

    <!-- Products section -->
    <section class='cart-section spad'>
		<div class='container'>
			<div class='row justify-content-center'>
				<div class='col-md-9'>
					<div class='text-center mb-5 alert-success' id='success' hidden>
						Produto excluído do sistema.
					</div>
					<div class='row'>
						<div class='col-xl-1 col-lg-5'>
							<a data-toggle="modal" data-target="#filtroModal" id='filtro' href='' title='Filtrar resultados'><img class='responsive' src='{{url("/img/icons/filter.png")}}' width='70px'></a>
						</div>
						<div class='col-xl-10 col-lg-5'>
							<div class='search'>
								<input type='text' name='search' id='search' placeholder='Encontre na página'>
								<button><i class='flaticon-search'></i></button>
							</div>
						</div>
						<div class='col-xl-1 col-lg-5'>
							<a href='{{url("adm/product/create")}}' title='Adicionar produto'><img class='responsive' src='{{url("/img/icons/newProduct.png")}}' width='70px'></a>
						</div>
					</div>
				</div>
				<div class='col-lg-9'>  
					<div class='exhibit-title'>
						<!-- continuar tentando fazer isso ser dinamico -->
						<hr> Exibindo {{$products->count()}} <div id="btnExibindo"></div> de {{$products->total()}} <hr>
					</div>
					<div class='cart-table'>
						<div class='cart-table-warp'>
							@csrf
							<table id='table' class='tablesorter'>
							<thead>
								<tr>
									<th class='product-th'>Nome</th>
									<th class='quy-th'>Preço</th>
                                    <th class='quy-th'>Estoque</th>
                                    <th class='quy-th' id='none'>Visualizar</th>
                                    <th class='quy-th' id='none'>Editar</th>
									<th class='quy-th' id='none'>Excluir</th>
								</tr>
							</thead>
							<tbody id='tbody'>
								@foreach($products as $prod)
								<tr>
									<td class='quy-col'>
                                        <a href='' title='Visualizar produto'>
                                            <div class='pc-title'>
                                                <h4>{{$prod->nmProduto}}</h4>
												<p>{{$prod->marca}}</p>
                                            </div>
                                        </a>
									</td>
									@php $precoProduto = str_replace('.', ',', $prod->precoProduto); @endphp
									<td class='quy-col'><center>{{$precoProduto}}</center></td>
                                    <td class='quy-col'><center>{{$prod->qtd}}</center></td>
                                    <td class='quy-col'><center><a href='{{url("adm/product/$prod->cdProduto")}}' title='Visualizar produto'><img class='responsive' src='{{url("/img/icons/seeProduct.png")}}' height='35px'></a></center></td>
                                    <td class='quy-col'><center><a href='{{url("adm/product/$prod->cdProduto/edit")}}' title='Editar produto'><img class='responsive' src='{{url("/img/icons/editProduct.png")}}' height='35px'></a></center></td>
									<td class='quy-col mt-3'><center><a data-toggle="modal" data-target="#deleteModal" data-id="{{$prod->cdProduto}}" data-nome="{{$prod->nmProduto}}" data-marca="{{$prod->marca}}" href="" 
										title='Excluir produto' class='js-del'><img class='responsive' src='{{url("/img/icons/deleteProduct.png")}}' height='35px'></a></center></td>

								</tr>
								@endforeach
							</tbody>
							</table>
                        </div>
                        <div class='total-cost-free'>
							<div class='row justify-content-end' id='pagination'>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
    <!-- Products section end -->

    <!-- Modal section -->
	
	<!-- Modal do filtro -->
	<form action="{{ route('ProductFilter') }}" method="post">
		@csrf
		<div class="modal fade" id="filtroModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Filtro de produto</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class='row form-group' > 
							<div class='col-md-6 col-xs-12'>
								<label for='nmProduto'>Produto</label>
								<input class="form-control" type='text' name='nmProduto' id='nmProduto' autofocus>
							</div>
							<div class='col-md-6 col-xs-12'>
								<label for='marca'>Marca</label>
								<input class="form-control" type='text' name='marca' id='marca' autofocus>
							</div>
						</div>
						<div class='row form-group' > 
							<div class='col-md-6 col-xs-12'>
								<label for='precoProduto'>Preço</label>
								<input class="form-control" type='text' placeholder='R$ 0,00' name='precoProduto' id='precoProduto' autofocus>
							</div>
							<div class='col-md-6 col-xs-12'>
								<label for='comissao'>Comissão</label>
								<input class="form-control" type='text' placeholder="0,0%" name='comissao' id='comissao' autofocus>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class='site-btn sb-dark' data-dismiss="modal">Cancelar</button>
						<button type="submit" class='site-btn' id='aplicar'>Aplicar</button>
					</div>
				</div>
			</div>
		</div>
	</form>

	<!-- Modal de exclusao -->

	<form id="deleteForm" method='get' action="{{ route('ProductDestroy', $prod->cdProduto) }}">

		<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Excluir produto</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Tem certeza que deseja excluir esse registro?</p> 
						<p> <strong>Nome do Produto:</strong> <input type="text" class="InputSemBorda" id="produto_nome" name="produto_nome" value="" readonly> <br>
						<strong>Marca:</strong> <input type="text" class="InputSemBorda" id="produto_marca" name="produto_marca" value="" readonly> </p>	
						
						<!-- <input type="hidden" id="produto_id" name="produto_id" value=""> -->
					</div>
					<div class="modal-footer">
						<button type="button" class='site-btn sb-dark' data-dismiss="modal">Não</button>
						<button type="submit" class='site-btn' id='del'>Sim</button>
					</div>
				</div>
			</div>
		</div>
	</form>

    <!-- Modal section end -->

	<script type="text/javascript">
		// FILTRO
		$('#filtroModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); 
        });

		// DELETAR
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); 
            var recipientId = button.data('id');
            var recipientNome = button.data('nome');
            var recipientMarca = button.data('marca');

            var modal = $(this);
            modal.find('#produto_id').val(recipientId);
            modal.find('#produto_nome').val(recipientNome);
            modal.find('#produto_marca').val(recipientMarca);
        });

		// onclick="exibir()"
		// document.getElementById('btnExibindo').innerHTML = '<select name="select">
		// 	<option onclick="exibir(3)" value="3" if()>3</option>
		// 	<option onclick="exibir(5)" value="5">5</option>
		// 	<option onclick="exibir(10)" value="10">10</option>
		// 	</select>';

		// document.getElementById('btnExibindo').innerHTML = '<button class="btn" onclick="exibir(1)">+</button><button class="btn" onclick="exibir(-1)">-</button>';

		// function exibir(valor){
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token_post"]').attr('content')
        //         }
        //     });

		// 	console.log(valor);

        //     dataString = "valor="+valor;

		// 	console.log(dataString);

        //     $.ajax({
        //         type: 'POST',
        //         data: dataString,
        //         url: "exibindo",
        //         success: function(resultado){
        //             console.log(resultado);
        //         }
        //     });
        // }
	</script>

@endsection('content')

@section('del') product @endsection('del')