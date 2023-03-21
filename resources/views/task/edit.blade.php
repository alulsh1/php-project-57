@extends('layouts.task.main') 
@section('content') 
        
@include('flash::message')

<div class="grid col-span-full">
<h1 class="mb-5">Изменение задачи</h1>
{{Form::model($task, ['route' => ['tasks.update', $task], 'method' => 'PATCH']) }}
<div class="flex flex-col">
{{Form::label('name', 'Имя') }}
<div class="mt-2">
{{Form::text('name', null, ['class' => 'rounded border-gray-300 w-1/3'])}}
</div>
@error('name')
<div class="text-rose-600">{{ $message }}</div>
@enderror
<div class="mt-2">
{{Form::label('description', 'Описание') }}
</div>
<div>
{{Form::textarea('description', null, ['class' => 'rounded border-gray-300 w-1/3 h-32', 'cols' => '50', 'rows' => '10'])}}
</div>
<div class="mt-2">
{{Form::label('status_id', 'Статус') }}
</div>
<div>
{{Form::select('status_id', $statuses, null, ['placeholder' => '----------', 'class' => 'rounded border-gray-300 w-1/3'])}}
</div>
@error('status_id')
<div class="text-rose-600">{{ $message }}</div>
@enderror
<div class="mt-2">
{{Form::label('assigned_to_id', 'Исполнитель') }}
</div>
<div>
{{Form::select('assigned_to_id', $users, null, ['placeholder' => '----------', 'class' => 'rounded border-gray-300 w-1/3'])}}
</div>
<div class="mt-2">
{{Form::label('labels[]', 'Метки') }}
</div>
{{Form::select('labels[]', $labels, null, ['placeholder' => '','multiple' => true, 'class' => 'rounded border-gray-300 w-1/3 h-32'])}}
</div>
<div class="mt-2">
{{ Form::submit('Обновить', ['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) }}
</div>
{{ Form::close() }}

</div>
@endsection 	