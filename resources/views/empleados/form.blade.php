
<div class="form-group">

	<label for="Nombre" class="control-label">{{'Nombre'}}</label>
	<input type="text" class="form-control @error('Nombre') is-invalid @enderror" name="Nombre" id="Nombre" 
	value="{{ isset($empleado->nombre) ? $empleado->nombre :old('Nombre')}}">

	@error('Nombre')
		<div class="invalid-feedback">{{ $message }} </div>
	@enderror

</div>

<div class="form-group"> {{-- Los "name", son los que se mandan como variables para la base de datos.. --}}

	<label for="ApellidoPaterno" class="control-label">{{'Apellido Paterno'}}</label>
	<input type="text" class="form-control @error('ApellidoPaterno') is-invalid @enderror" name="ApellidoPaterno" id="ApellidoPaterno" 
	value="{{ isset($empleado->apellidopater) ? $empleado->apellidopater : old('ApellidoPaterno')}}">

	@error('ApellidoPaterno')
		<div class="invalid-feedback">{{ $message }}</div>
	@enderror

</div>

<div class="form-group">

	<label for="ApellidoMaterno" class="control-label">{{'Apellido Materno'}}</label>
	<input type="text" class="form-control @error('ApellidoMaterno') is-invalid @enderror" name="ApellidoMaterno" id="ApellidoMaterno" 
	value="{{ isset($empleado->apellidomater) ? $empleado->apellidomater : old('ApellidoMaterno')}}">
	@error('ApellidoMaterno')
		<div class="invalid-feedback">{{ $message }}</div>
	@enderror

</div>

<div class="form-group">

	<label for="Correo" class="control-label">{{'Correo'}}</label>
	<input type="email" class="form-control @error('Correo') is-invalid @enderror" name="Correo" id="Correo" 
	value="{{ isset($empleado->correo) ? $empleado->correo : old('Correo')}}">
	@error('Correo')
		<div class="invalid-feedback">{{ $message }}</div>
	@enderror

</div>

<div class="form-group">

	<label for="Foto" class="control-label">{{'Foto'}}</label>
	@if(isset($empleado->foto))
		<br/>
		<img class="img-thumbnail img-fluid" src="{{ asset('storage').'/'.$empleado->foto}}" alt="" width="200px">
		<br/>
	@endif
	<input type="file" class="form-control @error('Foto') is-invalid @enderror" name="Foto" id="Foto" 
	value="{{ isset($empleado->foto) ? $empleado->foto : ''}}">
	@error('Foto')
		<div class="invalid-feedback">{{ $message }}</div>
	@enderror
</div>

	<input type="submit" class="btn btn-success" value="{{ $modo=='crear' ? 'Agregar':'Modificar'}}">
	<a class="btn btn-primary" href="{{url('empleados')}}">Regresar</a>