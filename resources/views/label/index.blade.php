@extends('layouts.task.main') 
@section('content') 
        
@include('flash::message')

<div class="grid col-span-full">
    <h1 class="mb-5">Метки</h1>
@auth() 
    <div>
            <a href="{{route('labels.create')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Создать метку            </a>
            </div>
@endauth 
    <table class="mt-4">
        <thead class="border-b-2 border-solid border-black text-left">
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Описание</th>
                <th>Дата создания</th>
               @auth()  <th>Действия</th>@endauth 
                </tr>
        </thead>
                <tbody>
				@foreach($labels as $label)
				<tr class="border-b border-dashed text-left">
                <td>{{$loop->iteration}}</td>
                <td>{{$label->name}}</td>
                <td>{{$label->description}}</td>
                <td>{{$label->dateAsCarbon->format('d.m.Y')}}</td>
				@auth() 
                <td>
                                            <a data-confirm="Вы уверены?" data-method="delete" class="text-red-600 hover:text-red-900" href="{{route('labels.destroy', $label->id)}}">
											
                            Удалить                        </a>
                                                                <a class="text-blue-600 hover:text-blue-900" href="{{route('labels.edit', $label->id)}}">
                            Изменить                        </a>
                                    </td>
									@endauth 
            </tr>
			@endforeach
            </tbody></table>

    
</div>
@endsection 	