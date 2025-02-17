@extends('layouts.app')

@section('content')
<h2 class="mb-4 text-xl font-bold">Contacts</h2>

<table class="w-full mt-4">
    <tr>
        <td class="p-2"><a href="{{ route('contacts.create') }}" class="px-4 py-2 text-white bg-blue-500 rounded">Add Contact</a>
        </td>
        <td class="p-2"><form action="{{ route('contacts.read.xml') }}" method="POST" enctype="multipart/form-data" class="mb-0 justify-right">
            @csrf
            <input type="file" name="xml_file" required class="p-2 border rounded">
            <button type="submit" class="px-4 py-2 text-white bg-purple-500 rounded">Upload XML</button>
        </form></td>
    </tr>
</table>
@if(session('success'))
    <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
        {{ session('error') }}
    </div>
@endif
@if($contacts->count() > 0)
<table class="w-full mt-4 border border-collapse border-gray-300">

    <thead>
        <tr class="bg-gray-200">
            <th class="p-2 border">Name</th>
            <th class="p-2 border">Phone</th>
            <th class="p-2 border">Actions</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($contacts as $contact)
        <tr>
            <td class="p-2 border">{{ $contact->name }}</td>
            <td class="p-2 border">{{ $contact->number }}</td>
            <td class="p-2 border">
                <a href="{{ route('contacts.edit', $contact) }}" class="px-2 py-1 text-white bg-blue-500 rounded">Edit</a>
                <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-2 py-1 text-white bg-red-500 rounded">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach

        <tr>
            <td>
                <div class="flex mt-6 mb-5 ml-2 justify-left">
                    {{ $contacts->links() }}
                </div>

            </td>
        </tr>
    </tbody>

</table>
@else
    <div class="p-4 text-center text-gray-600 bg-gray-100 rounded-lg">
        <p>No contacts found.</p>
    </div>
@endif
@endsection


