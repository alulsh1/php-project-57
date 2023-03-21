@extends('layouts.task.main') 
@section('content') 

<div class="grid col-span-full">
    <h1 class="mb-5">Создать метку</h1>

    <form method="POST" action="{{route('labels.store')}}" accept-charset="UTF-8" class="w-50">
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
        <div class="mt-2">
            <textarea class="rounded border-gray-300 w-1/3 h-32" name="description" cols="50" rows="10" id="description">
{{old('description') }}</textarea>
        </div>
                <div class="mt-2">
            <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit" value="Создать">
        </div>
    </div>
    </form>
</div>
@endsection 	