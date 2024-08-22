<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactInfo;

class ContactusController extends Controller
{
    public function index()
    {
        return view('contactus');
    }

    public function contactsave(Request $request)
    {
        $contact_data = $request->all();
        $contact_info = new ContactInfo();

        $contact_info->name = $contact_data['fname'].' '.$contact_data['lname']; //concatenating the first and last name

        $contact_info->email = $contact_data['email'];
        
        $contact_info->message = $contact_data['message'];

        $contact_info->contact_number = $contact_data['contact_number'];
        
        $contact_info->save();

        return redirect()->route('contact');

        //dd($contact_data);

        

    }
    
    public function showEntries()
    {
        $entries = ContactInfo::all();
        return view('contact_entries', compact('entries'));
    }



}
