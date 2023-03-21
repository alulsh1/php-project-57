@extends('layouts.task.main') 
@section('content') 
        
@include('flash::message')
<div class="grid col-span-full">
    <h1 class="mb-5">Изменение задачи</h1>
    <form method="POST" action="{{route('tasks.update', $task)}}" accept-charset="UTF-8" class="w-50"><input name="_method" type="hidden" value="PATCH">
	@csrf
	@method('patch')
    <div class="flex flex-col">
        <div>
            <label for="name">Имя</label>
        </div>
        <div class="mt-2">
  <input class="rounded border-gray-300 w-1/3" name="name" type="text" value="{{old('name', $task->name)}}" id="name">
  
</div>
@error('name')
<div class="text-rose-600">{{ $message }}</div>
@enderror
        <div class="mt-2">
            <label for="description">Описание</label>
        </div>
        <div>
        <textarea class="rounded border-gray-300 w-1/3 h-32" cols="50" rows="10" name="description" id="description" style="height: 183px;">{{old('description', $task->description)}}</textarea> 
        </div>
        <div class="mt-2">
            <label for="status_id">Статус</label>
        </div>
        <div>
            <select class="rounded border-gray-300 w-1/3" id="status_id" name="status_id">
			<option value="">----------</option>
			@foreach($statuses as $status)
			<option value="{{$status->id}}" 
			{{$status->id == old('status_id', $status->id) ? 'selected':''}}>{{$status->name}}</option>
			@endforeach

			</select>
        </div>
@error('status_id')
<div class="text-rose-600">{{ $message }}</div>
@enderror
                <div class="mt-2">
            <label for="assigned_to_id">Исполнитель</label>
        </div>
        <div>
            <select class="rounded border-gray-300 w-1/3" id="assigned_to_id" name="assigned_to_id">
			<option value="">----------</option>
			@foreach($users as $user)
			<option value="{{$user->id}}"
			{{$user->id == old('assigned_to_id', $user->id) ? 'selected':''}}>{{$user->name}}</option>	
				
			@endforeach
			</select>
        </div>

        <div class="mt-2">
            <label for="labels">Метки</label>
        </div>
        <div>
            <select multiple="multiple" name="labels[]" class="rounded border-gray-300 w-1/3 h-32" id="labels">
			<option value=""></option>

			@foreach($labels as $label)
			<option 
			@foreach($task->labels as $taskl)
			
			@if(!is_array(old('labels')))
			{{$taskl->id == $label->id ? 'selected' : ''}}		
			@elseif(old('labels') == null)
			@else			
			@foreach(old('labels') as $old)
			{{$old == $label->id ? 'selected' : ''}}
			@endforeach
			
			@endif
			
			@endforeach
			value="{{$label->id}}">{{$label->name}}</option>
			@endforeach
		
			</select>
        </div>	

        <div class="mt-2">
            <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit" value="Обновить">
        </div>
    </div>
    </form>

</div>
@endsection 	