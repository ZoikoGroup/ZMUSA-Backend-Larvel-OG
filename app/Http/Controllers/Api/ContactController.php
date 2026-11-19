<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;
use Mail;

class ContactController extends Controller
{
    public function ContactusPost(Request $request)
{
    // Validate request data
    $this->validate($request, [
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'message' => 'required'
    ]);

    // Save contact form data to database
    Contact::create($request->all());

    // Prepare email data
    $data = [
        'name' => $request->get('name'),
        'email' => $request->get('email'),
        'phone' => $request->get('phone'),
        'user_message' => $request->get('message')
    ];

    // Send mail to admin and user
    Mail::send('emails.contact-email', $data, function ($message) use ($request) {
        $message->from('info@zoikomobile.com', 'Zoiko Group');
        $message->to('info@zoikomobile.com', 'Admin')
                ->cc($request->get('email')) // Send a copy to the user
                ->subject('Contact Us Message');
    });

    // Return success response
    return response()->json([
        'success' => true,
        'message' => 'Thanks for contacting us. Your message has been sent successfully!'
    ], 200);
}


    public function get_messages()
    {
        $check_authentication = Auth::user();
        if ($check_authentication && $check_authentication->hasRole('admin')) {
            $contacts = Contact::orderBy('id', 'desc')->paginate(10);
            return response()->json([
                'success' => true,
                'message' => $contacts,
            ], 200);
        } else {
            return response()->json([
                'message' => $check_authentication,
            ], 200);
        }
        //return view("get_messages",['contacts'=>$contacts]);
    }

    public function destroy($id)
    {
        $authUser = Auth::user();

        if (!$authUser || !$authUser->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied.'
            ], 403);
        }

        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json([
                'success' => false,
                'message' => 'Record not found.'
            ], 404);
        }

        $contact->delete();

        return response()->json([
            'success' => true,
            'message' => 'Contact record deleted .'
        ], 200);
    }

}
