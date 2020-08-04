{!! Form::model($examen , [ 'method' => 'DELETE', 'action' => ['ExamenesController@destroy', $examen -> id]]) !!}
	{!! Form::submit($submitButton, ['class' => 'btn btn-danger']) !!}
{!! Form::close() !!}
