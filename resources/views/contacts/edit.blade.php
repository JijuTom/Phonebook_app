@extends('layouts.app')

@section('content')
<h2 class="mb-4 text-xl font-bold">{{ isset($contact) ? 'Edit Contact' : 'Add Contact' }}</h2>

<form action="{{ isset($contact) ? route('contacts.update', $contact) : route('contacts.store') }}" method="POST">
    @csrf
    @if(isset($contact)) @method('PUT') @endif

    <label class="block mb-2">Name</label>
    <input type="text" name="name" value="{{ old('name', $contact->name ?? '') }}" class="w-full p-2 border rounded">

    <label class="block mt-4 mb-2">Phone</label>
    <input type="text" name="number" value="{{ old('number', $contact->number ?? '') }}" class="w-full p-2 border rounded">

    <button type="submit" class="px-4 py-2 mt-4 text-white bg-green-500 rounded">{{ isset($contact) ? 'Update' : 'Save' }}</button>
    <a href="{{ route('contacts.index') }}" class="px-4 py-2 mt-4 text-white bg-gray-500 rounded">Cancel</a>
</form>
@endsection
