<div class="form-group col-md-10">
	{!! Form::label('Nombre','Nombre') !!}
	{!! Form::text('Nombre', null, ['class' => 'form-control trigger_change']) !!}
</div>
<div class="form-group col-md-1">
	{!! Form::label('Minutos','Minutos') !!}
	{!! Form::text('Minutos', null, ['class' => 'form-control trigger_change']) !!}
</div>
<div class="form-group col-md-1">
	{!! Form::label('Activo','Activo') !!}
	{!! Form::checkbox('Activo', 1, ($examen != null && $examen -> Activo != null) ,['class' => 'form-control trigger_change', 'style' => 'width: 30px;']) !!}
</div>
<div class="form-group col-md-11">
	{!! Form::label('Descripcion','Descripcion') !!}
	{!! Form::text('Descripcion', null, ['class' => 'form-control trigger_change']) !!}
</div>
<div class="form-group col-md-1">
	{!! Form::label('OrdenPreguntasFijo','Ordenadas') !!}
	{!! Form::checkbox('OrdenPreguntasFijo', 1, ($examen != null && $examen -> OrdenPreguntasFijo != null) ,['class' => 'form-control trigger_change', 'style' => 'width: 30px;']) !!}
</div>
@if($submitButton == 'Guardar')
<div class="form-group col-md-6">
	{!! Form::submit($submitButton, ['class' => 'btn btn-primary']) !!}
</div>
@endif
