@extends('templates.adm')

@section('title') Funcionários @endsection('title')

@section('icon') <img class='responsive' src='{{url("/img/icons/employee-light.png")}}' width='35px'> @endsection('icon')

@section('content')
    <!-- Employees section -->
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
							<a href='{{url("adm/employee/create")}}' title='Novo funcionário'><img class='responsive' src='{{url("/img/icons/newEmployee.png")}}' width='70px'></a>
						</div>
					</div>
				</div>
				<div class='col-lg-9'>  
					<div class='exhibit-title'>
						<hr> Exibindo {{$employees->count()}} de {{$employees->total()}}  <hr>
					</div>
					<div class='cart-table'>
						<div class='cart-table-warp'>
							@csrf
							<table id='table' class='tablesorter'>
								<thead>
									<tr>
										<th class='product-th'><br>Nome</th>
										<th class='quy-th'><br>Tipo</th>
										<th class='quy-th'><br>Telefone</th>
										<th class='quy-th'><br></th>
										<th class='quy-th' id='none'><br>Visualizar</th>
										<th class='quy-th' id='none'><br>Editar</th>
										<th class='quy-th' id='none'><br>Excluir</th>
									</tr>
								</thead>
								<tbody id='tbody'>
									@foreach($employees as $emp)
										@php    
											foreach($etypes as $type){
												if ($type->cdTipoFuncionario == $emp->cdTipoFuncionario){
													$tipo = $type;
												}
											}
										@endphp
									<tr>
										<td class='quy-col'>
											<a href='{{url("adm/employee/$emp->cdFuncionario")}}' title='Visualizar funcionário'>
												<div class='pc-title'>
													<h4>{{$emp->nmFuncionario}}</h4>
													<p>{{$emp->email}}</p>
												</div>
											</a>
										</td>
										<td><center>{{$tipo->nmFuncao}}</center></td>
										<td class='quy-col'><center>{{$emp->telefone}}</center></td>
										<td class='quy-col'><img class='responsive' scr='{{url("/img/blog-thumbs/line.png")}}' width='35px'></td>
										<td class='quy-col'><center><a href='{{url("adm/employee/$emp->cdFuncionario")}}' title='Visualizar funcionário'><img class='responsive' src='{{url("/img/icons/seeEmployee.png")}}' height='35px'></a></center></td>
										<td class='quy-col'><center><a href='{{url("/adm/employee/$emp->cdFuncionario/edit")}}' title='Editar funcionário'><img class='responsive' src='{{url("/img/icons/editEmployee.png")}}' height='35px'></a></center></td>
										<td class='quy-col mt-3'><center><a data-toggle="modal" data-target="#deleteModal" data-id="{{$emp->cdFuncionario}}" data-nmFuncionario="{{$emp->nmFuncionario}}" data-cpf="{{$emp->cpf}}" href="{{ route('EmpDestroy', $emp->cdFuncionario) }}" 
											title='Excluir funcionário' class='js-del'><img class='responsive' src='{{url("/img/icons/deleteEmployee.png")}}' height='35px'></a></center></td>
									</tr>
									@endforeach
								</tbody>
							</table>
                        </div>
                        <div class='total-cost-free'>
							<div class='row justify-content-end' id='pagination'>
						   		{{$employees->links()}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
    <!-- Employees section end -->

    <!-- Confirm modal section -->

	<!-- Modal do filtro -->
	<form action="{{ route('EmployeeFilter') }}" method="post">
		@csrf
		<div class="modal fade" id="filtroModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Filtro de funcionário</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class='row form-group' > 
							<div class='col-md-6 col-xs-12'>
								<label for='nmFuncionario'>Funcionário</label>
								<input class="form-control" type='text' name='nmFuncionario' id='nmFuncionario' autofocus>
							</div>
							<div class='col-md-6 col-xs-12'>
								<label for='cpf'>CPF</label>
								<input class="form-control" type='text' placeholder='000.000.000-00' name='cpf' id='cpf' autofocus>
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
	<form id="deleteForm" method='get' action="{{ route('EmpDestroy', $emp->cdFuncionario) }}">

		<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Excluir funcionário</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Tem certeza que deseja excluir esse registro?</p> 
						<p> <strong>Nome do Funcionário:</strong> <input type="text" class="InputSemBorda" id="funcionario_nome" name="funcionario_nome" value="" readonly> <br>
						<strong>CPF:</strong> <input type="text" class="InputSemBorda" id="funcionario_cpf" name="funcionario_cpf" value="" readonly> </p>	
						
						<!-- <input type="hidden" id="funcionario_id" name="funcionario_id" value=""> -->
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
            var recipientNome = button.data('nmFuncionario');
            var recipientCpf = button.data('cpf');

            var modal = $(this);
            modal.find('#funcionario_id').val(recipientId);
            modal.find('#funcionario_nome').val(recipientNome);
            modal.find('#funcionario_cpf').val(recipientCpf);
        });
	</script>

@endsection('content')

@section('del') employee @endsection('del')