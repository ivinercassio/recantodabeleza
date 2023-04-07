@extends('templates.adm')

@section('title') Serviços @endsection('title')

@section('icon') <img class='responsive' src='{{url("/img/icons/service-light.png")}}' width='35px'> @endsection('icon')

@section('content')
    <!-- services section -->
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
							<a href='{{url("adm/service/create")}}' title='Adicionar serviço'><img class='responsive' src='{{url("/img/icons/newService.png")}}' width='70px'></a>
						</div>
					</div>
				</div>
				<div class='col-lg-9'>  
					<div class='exhibit-title'>
						<hr> Exibindo {{$services->count()}} de {{$services->total()}} <hr>
					</div>
					<div class='cart-table'>
						<div class='cart-table-warp'>
							@csrf
							<table id='table' class='tablesorter'>
							<thead>
								<tr>
									<th class='product-th'><br>Nome</th>
									<th class='quy-th'><br>Valor</th>
									<th class='quy-th'><br>Comissão</th>
                                    <th class='quy-th' id='none'><br>Visualizar</th>
                                    <th class='quy-th' id='none'><br>Editar</th>
									<th class='quy-th' id='none'><br>Excluir</th>
								</tr>
							</thead>
							<tbody id='tbody'>
								@foreach($services as $svc)
								<tr>
									<td class='quy-col'>
                                        <a href='{{url("adm/service/$svc->cdServico")}}' title='Visualizar serviço'>
                                            <div class='pc-title mt-1.5'>
                                                <h4>{{$svc->nmServico}}</h4>
                                            </div>
                                        </a>
									</td>
									@php $valorServico = str_replace('.', ',', $svc->valorServico); @endphp
									<td class='quy-col mt-3'><center>R${{$valorServico}}</center></td>
									<td class='quy-col mt-3'><center>{{$svc->comissao*100}}%</center></td>
                                    <td class='quy-col mt-3'><center><a href='{{url("adm/service/$svc->cdServico")}}' title='Visualizar serviço'><img class='responsive' src='{{url("/img/icons/seeService.png")}}' height='35px'></a></center></td>
                                    <td class='quy-col mt-3'><center><a href='{{url("/adm/service/$svc->cdServico/edit")}}' title='Editar serviço'><img class='responsive' src='{{url("/img/icons/editService.png")}}' height='35px'></a></center></td>
									<td class='quy-col mt-3'><center><a data-toggle="modal" data-target="#deleteModal" data-id="{{$svc->cdServico}}" data-nome="{{$svc->nmServico}}" data-valor="{{$valorServico}}" href="" 
										title='Excluir serviço' class='js-del'><img class='responsive' src='{{url("/img/icons/deleteService.png")}}' height='35px'></a></center></td>

								</tr>
								@endforeach
							</tbody>
							</table>
                        </div>
                        <div class='total-cost-free'>
							<div class='row justify-content-end' id='pagination'>
						   		{{$services->links()}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
    <!-- services section end -->

    <!-- Confirm modal section -->

	<!-- Modal do filtro -->
	<form action="{{ route('ServiceFilter') }}" method="post">
		@csrf
		<div class="modal fade" id="filtroModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Filtro de serviço</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class='row form-group' > 
							<div class='col-md-6 col-xs-12'>
								<label for='nmServico'>Serviço</label>
								<input class="form-control" type='text' name='nmServico' id='nmServico' autofocus>
							</div>
							<div class='col-md-6 col-xs-12'>
								<label for='valorServico'>Valor</label>
								<input class="form-control" type='text' placeholder="R$ 0,00" name='valorServico' id='valorServico' autofocus>
							</div>
						</div>
						<div class='row form-group' > 
							<div class='col-md-12 col-xs-12'>
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
	<form id="deleteForm" method='get' action="{{ route('ServicoDestroy', $svc->cdServico) }}">

		<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Excluir serviço</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Tem certeza que deseja excluir esse registro?</p> 
						<p> <strong>Nome do Serviço:</strong> <input type="text" class="InputSemBorda" id="servico_nome" name="servico_nome" value="" readonly> <br>
						<strong>Valor:</strong> <input type="text" class="InputSemBorda" id="servico_valor" name="servico_valor" value="" readonly> </p>	
						
						<input type="hidden" id="id" name="id" value="">
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
            var recipientValor = button.data('valor');

            var modal = $(this);
            modal.find('#id').val(recipientId);
            modal.find('#servico_nome').val(recipientNome);
            modal.find('#servico_valor').val(recipientValor);
        });
	</script>

@endsection('content')

@section('del') service @endsection('del')