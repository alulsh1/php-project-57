@extends('layouts.task.main') 
@section('content') 
        
@include('flash::message')

<div class="grid col-span-full">
    <h1 class="mb-5">Статусы</h1>
@auth() 
				<div>
                    <a href="{{route('task_statuses.create')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Создать статус            </a>
            </div>
@endauth 
<table class="mt-4">
        <thead class="border-b-2 border-solid border-black text-left">
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Дата создания</th>
				
				@auth()
                                    <th>Действия</th>
				@endauth 				
                            </tr>
        </thead>
                    <tbody>
				@foreach($statuses as $status)	
			<tr class="border-b border-dashed text-left">
                <td>{{$loop->iteration}}</td>
                <td>{{$status->name}}</td>
                <td>{{$status->dateAsCarbon->format('d.m.Y')}}</td>
				@auth()
                <td>
                 <a  rel="nofollow" data-confirm="Вы уверены?" data-method="delete" class="text-red-600 hover:text-red-900" href="{{route('task_statuses.destroy', $status->id)}}">
                            Удалить                        </a>
                <a class="text-blue-600 hover:text-blue-900" href="{{route('task_statuses.edit', $status->id)}}">
                            Изменить                        </a>
                </td>
				@endauth 
            </tr>
			@endforeach
			
            </tbody></table>
    
</div>
@endsection 	