@extends('templates.adm')

@section('title') Tipos de Funcionário @endsection('title')

@section('icon') <img class='responsive' src='{{url("/img/icons/employeeType.png")}}' width='35px'> @endsection('icon')

@section('content')
    <!-- EmployeeTypes section -->
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
							<a href='{{url("adm/employeeType/create")}}' title='Novo funcionário'><img class='responsive' src='{{url("/img/icons/newEmployeeType.png")}}' width='70px'></a>
						</div>
					</div>
				</div>
				<div class='col-lg-9'>  
					<div class='exhibit-title'>
						<hr> Exibindo {{$etypes->count()}} de {{$etypes->total()}}  <hr>
					</div>
					<div class='cart-table'>
						<div class='cart-table-warp'>
							@csrf
							<table id='table' class='tablesorter'>
							<thead>
								<tr>
									<th class='product-th'>Funcao</th>
									<th class='quy-th' id='none'>Base</th>
									<th class='quy-th' id='none'></th>
                                    <!-- <th class='quy-th' id='none'>Visualizar</th> -->
                                    <th class='quy-th' id='none'>Editar</th>
									<th class='quy-th' id='none'>Excluir</th>
								</tr>
							</thead>
							<tbody id='tbody'>
								@foreach($etypes as $emp)
								<tr>
									<td class='quy-col'>
										<div class='pc-title'>
											<h4>{{$emp->nmFuncao}}</h4>
										</div>
									</td>
									<td class='quy-col'><center>R${{$emp->salarioBase()}}</center></td>
									<td class='quy-col'><img class='responsive' scr='{{url("/img/blog-thumbs/line.png")}}' width='35px'></td>
                                    <!-- <td class='quy-col'><center><a href='{{url("adm/employeeType/$emp->cdTipoFuncionario")}}' title='Visualizar função'><img class='responsive' src='{{url("/img/icons/seeEmployeeType.png")}}' height='35px'></a></center></td> -->
                                    <td class='quy-col'><center><a href='{{url("/adm/employeeType/$emp->cdTipoFuncionario/edit")}}' title='Editar função'><img class='responsive' src='{{url("/img/icons/editEmployeeType.png")}}' height='35px'></a></center></td>
									<td class='quy-col mt-3'><center><a data-toggle="modal" data-target="#deleteModal" data-id="{{$emp->cdTipoFuncionario}}" data-nome="{{$emp->nmFuncao}}" data-base="{{$emp->salarioBase()}}" href="{{ route('EmpTypeDestroy', $emp->cdTipoFuncionario) }}" 
										title='Excluir funcionário' class='js-del'><img class='responsive' src='{{url("/img/icons/deleteEmployeeType.png")}}' height='35px'></a></center></td>

								</tr>
								@endforeach
							</tbody>
							</table>
                        </div>
                        <div class='total-cost-free'>
                            <a href='{{url("adm/employee")}}' class='site-btn sb-dark ml-4'>Voltar</a>
							<div class='row justify-content-end' id='pagination'>
						   		{{$etypes->links()}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
    <!-- EmployeeTypes section end -->

    <!-- Modal section -->

	<!-- Modal do filtro -->
	<form action="{{ route('EmpTypeFilter') }}" method="post">
		@csrf
		<div class="modal fade" id="filtroModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Filtro de Tipo Funcionário</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class='row form-group' > 
							<div class='col-md-6 col-xs-12'>
								<label for='nmFuncao'>Função</label>
								<input class="form-control" type='text' name='nmFuncao' id='nmFuncao' autofocus>
							</div>
							<div class='col-md-6 col-xs-12'>
								<label for='salarioBase'>Base</label>
								<input class="form-control" type='text' placeholder='R$ 0,00' name='salarioBase' id='salarioBase' autofocus>
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
	<form id="deleteForm" method='get' action="{{ route('EmpTypeDestroy', $emp->cdTipoFuncionario) }}">

		<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Excluir Função</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Tem certeza que deseja excluir esse registro?</p> 
						<p> <strong>Função:</strong> <input type="text" class="InputSemBorda" id="tipoFuncionario_nome" name="tipoFuncionario_nome" value="" readonly> <br>
						<strong>Base:</strong> <input type="text" class="InputSemBorda" id="tipoFuncionario_base" name="tipoFuncionario_base" value="" readonly> </p>	
						
						<!-- <input type="hidden" id="tipoFuncionario_id" name="tipoFuncionario_id" value=""> -->
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
            var recipientBase = button.data('base');

            var modal = $(this);
            modal.find('#tipoFuncionario_id').val(recipientId);
            modal.find('#tipoFuncionario_nome').val(recipientNome);
            modal.find('#tipoFuncionario_base').val(recipientBase);
        });
	</script>


@endsection('content')

@section('del') employeeType @endsection('del')