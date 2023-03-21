@extends('layouts.task.main') 
@section('content') 
        
@include('flash::message')
<div class="grid col-span-full">
    <h1 class="mb-5">Создать задачу</h1>

    <form method="POST" action="{{@route('tasks.store')}}" accept-charset="UTF-8" class="w-50">
	@csrf
    <div class="flex flex-col">
        <div>
            <label for="name">Имя</label>
        </div>
        <div class="mt-2">
  <input class="rounded border-gray-300 w-1/3" name="name" type="text" id="name" value="{{old('name')}}">
</div>
@error('name')
<div class="text-rose-600">{{ $message }}</div>
@enderror
        <div class="mt-2">
            <label for="description">Описание</label>
        </div>
        <div>
<textarea class="rounded border-gray-300 w-1/3 h-32" cols="50" rows="10" name="description" id="description">{{old('description')}}
</textarea>
        </div>
        <div class="mt-2">
            <label for="status_id">Статус</label>
        </div>
        <div>
            <select class="rounded border-gray-300 w-1/3" id="status_id" name="status_id">
			<option selected="selected" value="">----------</option>
			@foreach($statuses as $status)
			<option value="{{$status->id}}"
			{{$status->id == old('status_id') ? 'selected' : ''}}
			>{{$status->name}}</option>
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
            <select class="rounded border-gray-300 w-1/3" id="assigned_to_id" name="assigned_to_id"><option selected="selected" value="">----------</option>
			@foreach($users as $user)
			<option value="{{$user->id}}"
			{{$user->id == old('assigned_to_id') ? 'selected' : ''}}
			>{{$user->name}}</option>
			@endforeach		
			</select>
        </div>
		
        <div class="mt-2">
            <label for="labels">Метки</label>
        </div>
        <div>
            <select multiple="multiple" name="labels[]" class="rounded border-gray-300 w-1/3 h-32" id="labels">
			<option value="" {{is_array(old('labels')) ? '' : "selected"}} ></option>
			@foreach($labels as $label)
			<option value="{{$label->id}}" {{is_array(old('labels')) && in_array($label->id, old('labels')) ? 'selected' : ''}}>{{$label->name}}</option>
			@endforeach			
			</select>
        </div>
			
        <div class="mt-2">
            <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit" value="Создать">
        </div>
    </div>
    </form>
</div>

@endsection 	