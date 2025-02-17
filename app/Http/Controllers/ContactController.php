<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class ContactController extends Controller
{

    public function index()
    {
        $contacts = Contact::paginate(10);
        return view('contacts.index', data: ['contacts' => $contacts]);
    }


    public function create()
    {
        return view('contacts.create');
    }

    public function readXML(Request $request)
    {
        $request->validate([
            'xml_file' => 'required|file|mimes:xml|max:2048'
        ]);

        $file = $request->file('xml_file');
        $xmlContent = simplexml_load_file($file->getPathname());
        if (!$xmlContent) {
            return redirect()->route('contacts.index')->with('error', 'Invalid XML format.');

        }

        $path = $request->file('xml_file')->store('temp');

        $xmlString = Storage::get($path);
        $xml = new SimpleXMLElement($xmlString);

        foreach ($xml->contact as $contact) {
            $name = (string) $contact->name;
            $phone = (string) $contact->phone;


            Contact::firstOrCreate(

                ['name' => $name],
                ['number' => $phone]
            );
        }

        Storage::delete($path);
        return redirect()->route('contacts.index')->with('success', 'Contacts imported successfully!');
    }

    public function store(Request $request)
    {

            $request->validate([
                'name' => 'required',
                'number' => 'required|unique:contacts',
            ]);

            Contact::create($request->all());

            return redirect()->route('contacts.index')->with('success', 'Contact added successfully!');

    }


    public function show(string $id)
    {
        //
    }


    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }


    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'name' => 'required',
            'number' => 'required|unique:contacts'
        ]);

        $contact->update($request->all());
        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully!');

    }


    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully!');
    }
}
