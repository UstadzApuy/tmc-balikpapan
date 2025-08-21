<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller {
    public function index() {
        $contacts = Contact::paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }

    // Admin hanya bisa melihat dan mengupdate kontak yang ada
    
    public function edit(Contact $contact) {
        return view('admin.contacts.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact) {
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'url' => 'nullable|url',
            'order' => 'required|integer',
        ]);

        $contact->update($request->all());
        return redirect()->route('admin.contacts.index')->with('success', 'Contact updated successfully.');
    }

    // Method destroy() dihapus - admin tidak bisa menghapus kontak
}
