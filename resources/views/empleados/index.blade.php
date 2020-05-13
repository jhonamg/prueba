@extends('layouts.app')

@section('content')
{{-- <script type="text/javascript">
		function prueba($a){
		const swalWithBootstrapButtons = Swal.mixin({
	  customClass: {
	    confirmButton: 'btn btn-success',
	    cancelButton: 'btn btn-danger'
	  },
	  buttonsStyling: false
	})

	swalWithBootstrapButtons.fire({
	  title: 'Estas seguro?',
	  text: "No seras capaz de revertirlo!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonText: 'Si, Borrarlo!',
	  cancelButtonText: 'No, cancelar!',
	  reverseButtons: true
	}).then((result) => {
	  if (result.value) {
	    swalWithBootstrapButtons.fire(
	      'Borrado!',
	      'Su archivo ha sido borrado.',
	      'success'
	    )
	  } else if (
	    /* Read more about handling dismissals below */
	    result.dismiss === Swal.DismissReason.cancel
	  ) {
	    swalWithBootstrapButtons.fire(
	      'Cancelado',
	      'El archivo permanece igual ',
	      'error'
	    )
	  }
	})
}</script> --}}

<div class="container">

	@if(Session::has('Mensaje'))
	
	
		<script>
			Swal.fire({
			position: 'top-end',
			icon: 'success',
			title: '{{	Session::get('Mensaje') }}',
			showConfirmButton: true,
			timer: 1000
			})
		</script>

	@endif

	<a href="{{url('empleados/create')}}" class="btn btn-success">Agregar Empleado</a>
	<br/>
	<br/>

	<table class="table table-light table-hover">
		<thead class="thead-light">
			<tr>
				<th>#</th>
				<th>Foto</th>
				<th>Nombre</th>
				{{-- <th>Apellido Paterno</th>
				<th>Apellido Materno</th> --}}
				<th>Correo</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			@foreach($empleados as $empleado)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>
						<img src="{{ asset('storage').'/'.$empleado->foto}}" class="img-thumbnail img-fluid" alt="" width="100px">	
					</td>
					<td>{{$empleado->nombre}} {{$empleado->apellidopater}} {{$empleado->apellidomater}}</td>
					{{-- <td>{{$empleado->apellidopater}}</td>
					<td>{{$empleado->apellidomater}}</td> --}}
					<td>{{$empleado->correo}}</td>
					<td>

					<a class="btn btn-warning" href="{{url('empleados/'.$empleado->id.'/edit')}}">
						Editar
					</a> 

						<form method="post" action="{{ url('/empleados/'.$empleado->id) }}" style="display:inline;">
						
						{{csrf_field()}}
						{{ method_field('DELETE') }}

						<button class="btn btn-danger" type="submit" onclick="return confirm('Borrar?');">Borrar</button>
						
						</form>


					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	{{ $empleados->links() }}

</div>
@endsection

