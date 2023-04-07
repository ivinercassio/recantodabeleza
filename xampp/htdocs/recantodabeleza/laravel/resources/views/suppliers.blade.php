@extends('templates.adm')

@section('title') Fornecedores @endsection('title')

@section('icon') <img class='responsive' src='{{url("/img/icons/supplier-light.png")}}' width='35px'> @endsection('icon')

@section('content')
    <!-- Suppliers section -->
    <section class='cart-section spad'>
		<div class='container'>
			<div class='row justify-content-center'>
				<div class='col-md-9'>
					<div class='text-center mb-5 alert-success' id='success' hidden>
						Fornecedor excluído do sistema.
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
							<a href='{{url("adm/supplier/create")}}' title='Novo fornecedor'><img class='responsive' src='{{url("/img/icons/newSupplier.png")}}' width='70px'></a>
						</div>
					</div>
				</div>
				<div class='col-lg-9'>  
					<div class='exhibit-title'>
						<hr> Exibindo {{$suppliers->count()}} de {{$suppliers->total()}}  <hr>
					</div>
					<div class='cart-table'>
						<div class='cart-table-warp'>
							@csrf
							<table id='table' class='tablesorter'>
							<thead>
								<tr>
									<th class='product-th'>Nome</th>
									<th class='quy-th'>Telefone</th>
									<th class='quy-th'></th>
                                    <th class='quy-th' id='none'>Visualizar</th>
                                    <th class='quy-th' id='none'>Editar</th>
									<th class='quy-th' id='none'>Excluir</th>
								</tr>
							</thead>
							<tbody id='tbody'>
								@foreach($suppliers as $sup)
								<tr>
									<td class='quy-col'>
                                        <a href='{{url("adm/supplier/$sup->cdFornecedor")}}' title='Visualizar fornecedor'>
                                            <div class='pc-title'>
                                                <h4>{{$sup->nmFornecedor}}</h4>
												<p>{{$sup->email}}</p>
                                            </div>
                                        </a>
									</td>
									<td class='quy-col'><center>{{$sup->telefone}}</center></td>
									<td class='quy-col'><img class='responsive' scr='{{url("/img/blog-thumbs/line.png")}}' width='35px'></td>
                                    <td class='quy-col'><center><a href='{{url("adm/supplier/$sup->cdFornecedor")}}' title='Visualizar fornecedor'><img class='responsive' src='{{url("/img/icons/seeSupplier.png")}}' height='35px'></a></center></td>
                                    <td class='quy-col'><center><a href='{{url("/adm/supplier/$sup->cdFornecedor/edit")}}' title='Editar fornecedor'><img class='responsive' src='{{url("/img/icons/editSupplier.png")}}' height='35px'></a></center></td>
									<td class='quy-col mt-3'><center><a data-toggle="modal" data-target="#deleteModal" data-id="{{$sup->cdFornecedor}}" data-nome="{{$sup->nmFornecedor}}" data-email="{{$sup->email}}" href="{{ route('SupDestroy', $sup->cdFornecedor) }}" 
										title='Excluir fornecedor' class='js-del'><img class='responsive' src='{{url("/img/icons/deleteSupplier.png")}}' height='35px'></a></center></td>

								</tr>
								@endforeach
							</tbody>
							</table>
                        </div>
                        <div class='total-cost-free'>
							<div class='row justify-content-end' id='pagination'>
						   		{{$suppliers->links()}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
    <!-- Suppliers section end -->

    <!-- Modal section -->

	<!-- Modal do filtro -->
	<form action="{{ route('SuppliersFilter') }}" method="post">
		@csrf
		<div class="modal fade" id="filtroModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Filtro de fornecedor</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class='row form-group' > 
							<div class='col-md-6 col-xs-12'>
								<label for='nmFornecedor'>Fornecedor</label>
								<input class="form-control" type='text' name='nmFornecedor' id='nmFornecedor' autofocus>
							</div>
							<div class='col-md-6 col-xs-12'>
								<label for='cnpj'>CNPJ</label>
								<input class="form-control" type='text' placeholder='00.000.000/0000-00' name='cnpj' id='cnpj' autofocus>
							</div>
						</div>
						<div class='row form-group' > 
							<div class='col-md-6 col-xs-12'>
								<label for='telefone'>Telefone</label>
								<input class="form-control" type='text' placeholder='(00) 0000-0000' name='telefone' id='telefone' autofocus>
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
	<form id="deleteForm" method='get' action="{{ route('SupDestroy', $sup->cdFornecedor) }}">

		<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Excluir fornecedor</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Tem certeza que deseja excluir esse registro?</p> 
						<p> <strong>Nome do Fornecedor:</strong> <input type="text" class="InputSemBorda"id="fornecedor_nome" name="fornecedor_nome" value="" readonly> <br>
						<strong>E-mail:</strong> <input type="text" class="InputSemBorda" id="fornecedor_email" name="fornecedor_email" value="" readonly> </p>	
						
						<!-- <input type="hidden" id="fornecedor_id" name="fornecedor_id" value=""> -->
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
            var recipientEmail = button.data('email');

            var modal = $(this);
            modal.find('#fornecedor_id').val(recipientId);
            modal.find('#fornecedor_nome').val(recipientNome);
            modal.find('#fornecedor_email').val(recipientEmail);
        });

	</script>

@endsection('content')

@section('del') supplier @endsection('del')