@extends('layouts.task.main') 
@section('content') 
        
@include('flash::message')
<div class="grid col-span-full">
    <h1 class="mb-5">Задачи</h1>

    <div class="w-full flex items-center">
        <div>
			{{Form::open(['route' => 'tasks.index', 'method' => 'get'])}}
			<div class="flex">
			<div>
			{{Form::select('filter[status_id]', $statuses, $query['status_id'] ?? 'Статус', ['placeholder' => 'Статус', 'class' => 'rounded border-gray-300'])}}
			</div>
			
			<div>
			{{Form::select('filter[created_by_id]', $users, $query['created_by_id'] ?? 'Автор', ['placeholder' => 'Автор', 'class' => 'ml-2 rounded border-gray-300'])}}
			</div>
			
			<div>
			{{Form::select('filter[assigned_to_id]', $users, $query['assigned_to_id'] ?? 'Исполнитель', ['placeholder' => 'Исполнитель', 'class' => 'ml-2 rounded border-gray-300'])}}
			</div>
			
			<div>
			{{ Form::submit('Применить', ['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2']) }}
			</div>
			{{Form::close()}}
			</div>
        </div>
        <div class="ml-auto">
		@auth()
		<a href="{{route('tasks.create')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                Создать задачу            
		</a>
		@endauth 
                    </div>
    </div>

    <table class="mt-4">
        <thead class="border-b-2 border-solid border-black text-left">
            <tr>
                <th>ID</th>
                <th>Статус</th>
                <th>Имя</th>
                <th>Автор</th>
                <th>Исполнитель</th>
                <th>Дата создания</th>
			@auth() 	<th>Действия</th>@endauth 
                            </tr>
        </thead>
            <tbody>
			@foreach($tasks as $task)
			<tr class="border-b border-dashed text-left">		
            <td>{{$task->id}}</td>
            <td>{{$task->status->name}}</td>
            <td>
                <a class="text-blue-600 hover:text-blue-900" href="{{route('tasks.show', $task->id)}}">
                   {{$task->name}}
                </a>
            </td>
            <td>{{$task->userCreate->name}}</td>
            <td>@if(isset($task->userTask->name)) {{$task->userTask->name}}@endif</td>
            <td>{{$task->dateAsCarbon->format('d.m.Y')}}</td>
           @auth()  <td>

			@if(Auth::id() === $task->userCreate->id)
			<a data-confirm="Вы уверены?" data-method="delete" href="{{route('tasks.destroy', $task->id)}}" class="text-red-600 hover:text-red-900">
                    Удалить</a>
			@endif 
			<a href="{{route('tasks.edit', $task)}}" class="text-blue-600 hover:text-blue-900">
                    Изменить</a>
		
           </td>@endauth 
			</tr>
			@endforeach
            </tbody>
			</table>

    <div class="mt-4">
	{{ $tasks->links() }}
    </div>
</div>
@endsection 	