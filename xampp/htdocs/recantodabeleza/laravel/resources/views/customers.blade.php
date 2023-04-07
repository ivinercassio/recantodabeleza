@extends('templates.adm')

@section('title') Clientes @endsection('title')

@section('icon') <img class='responsive' src='{{url("/img/icons/client.png")}}' width='35px'> @endsection('icon')

@section('content')
    <!-- customers section -->
    <section class='cart-section spad'>
		<div class='container'>	
			<div class='row justify-content-center'>
				<div class='col-md-9'>
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
							<a href='{{url("adm/customer/create")}}' title='Adicionar cliente'><img class='responsive' src='{{url("/img/icons/newClient.png")}}' width='70px'></a>
						</div>
					</div>
				</div>
				<div class='col-lg-9'>  
					<div class='exhibit-title'>
						<hr> Exibindo {{$customers->count()}} de {{$customers->total()}} <hr>
					<div>
				</div>
					<div class='cart-table'>
						<div class='cart-table-warp'>
							@csrf
							<table id='table' class='tablesorter'>
							<thead>
								<tr>
									<th class='product-th'><br>Nome e contato</th>
									<th class='quy-th'><br>E-mail</th>
                                    <th class='quy-th' id='none'><br>Visualizar</th>
                                    <th class='quy-th' id='none'><br>Editar</th>
									<th class='quy-th' id='none'><br>Excluir</th>
								</tr>
							</thead>
							<tbody id='tbody'>
                            @foreach($customers as $cust)
								<tr>
									<td class='quy-col'>
                                        <a href='{{url("adm/customer/$cust->cdCliente")}}' title='Visualizar Cliente'>
                                            <div class='pc-title mt-1.5'>
                                                <h4>{{$cust->nmCliente}}</h4>
												<p>{{$cust->telefone}}</p>
                                            </div>
                                        </a>
									</td>
									<td class='quy-col mt-3'><center>{{$cust->email}}</center></td>
                                    <td class='quy-col mt-3'><center><a href='{{url("adm/customer/$cust->cdCliente")}}' title='Visualizar cliente'><img class='responsive' src='{{url("/img/icons/seeClient.png")}}' height='35px'></a></center></td>
                                    <td class='quy-col mt-3'><center><a href='{{url("/adm/customer/$cust->cdCliente/edit")}}' title='Editar cliente'><img class='responsive' src='{{url("/img/icons/editClient.png")}}' height='35px'></a></center></td>
									<td class='quy-col mt-3'><center><a data-toggle="modal" data-target="#deleteModal" data-id="{{$cust->cdCliente}}" data-nome="{{$cust->nmCliente}}" data-rg="{{$cust->rg}}" href="" 
										title='Excluir cliente' class='js-del'><img class='responsive' src='{{url("/img/icons/deleteClient.png")}}' height='35px'></a></center></td>
								</tr>
                            @endforeach
							</tbody>
							</table>
                        </div>
                        <div class='total-cost-free'>
							<div class='row justify-content-end' id='pagination'>
								{{$customers->links()}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
    <!-- customers section end -->

    <!-- Confirm modal section -->

		<!-- Modal do filtro -->
		<form action="{{ route('CustomerFilter') }}" method="post">
			@csrf
			<div class="modal fade" id="filtroModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Filtro de cliente</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class='row form-group' > 
								<div class='col-md-6 col-xs-12'>
									<label for='nmCliente'>Cliente</label>
									<input class="form-control" type='text' name='nmCliente' id='nmCliente' autofocus>
								</div>
								<div class='col-md-6 col-xs-12'>
									<label for='rg'>RG</label>
									<input class="form-control" type='text' placeholder='00-00.000.000' name='rg' id='rg' autofocus>
								</div>
							</div>
							<div class='row form-group' > 
								<div class='col-md-6 col-xs-12'>
									<label for='telefone'>Telefone</label>
									<input class="form-control" type='text' placeholder='(00) 00000-0000' name='telefone' id='telefone' autofocus>
								</div>
								<div class='col-md-6 col-xs-12'>
									<label for='email'>E-mail</label>
									<input class="form-control" type='text' name='email' id='email' autofocus>
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
		<form id="deleteForm" method='get' action="{{ route('CustDestroy') }}">

			<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Excluir cliente</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<p>Tem certeza que deseja excluir esse registro?</p> 
							<p> <strong>Nome do Cliente:</strong> <input type="text" class="InputSemBorda" id="cliente_nome" name="cliente_nome" value="" readonly> <br>
							<strong>RG:</strong> <input type="text" class="InputSemBorda" id="cliente_rg" name="cliente_rg" value="" readonly> </p>	
							
							<input type="hidden" id="cliente_id" name="cliente_id" value="">
						</div>
						<div class="modal-footer">
							<button type="button" class='site-btn sb-dark' data-dismiss="modal">Não</button>
							<button type="submit" class='site-btn' id='del'>Sim</button>
						</div>
					</div>
				</div>
			</div>
		</form>

    <!-- Confirm modal section end -->

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
            var recipientRg = button.data('rg');

			console.log(recipientNome);

            var modal = $(this);
            modal.find('#cliente_id').val(recipientId);
            modal.find('#cliente_nome').val(recipientNome);
            modal.find('#cliente_rg').val(recipientRg);
        });
	</script>

@endsection('content')

@section('del') customer @endsection('del')