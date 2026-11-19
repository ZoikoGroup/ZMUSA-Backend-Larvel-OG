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
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:50',
            'message' => 'nullable|string|max:5000',
        ]);

        // Extra fields from other forms (e.g. Music & Events Perk) are added to the message
        $extra = collect($request->except(['name', 'email', 'phone', 'message', '_token']))
            ->filter(fn ($v) => $v !== null && $v !== '')
            ->map(function ($v, $k) {
                $label = ucfirst(str_replace(['_', '-'], ' ', $k));
                if (is_bool($v)) {
                    $v = $v ? 'Yes' : 'No';
                } elseif (is_array($v)) {
                    $v = json_encode($v);
                }
                return "{$label}: {$v}";
            })
            ->implode("\n");

        $message = trim(($data['message'] ?? '') . ($extra !== '' ? "\n\n" . $extra : ''));

        $contact = Contact::create([
            'name'    => $data['name'],
            'email'   => $data['email'],
            'phone'   => $data['phone'] ?? '',
            'message' => $message,
        ]);

        try {
            Mail::send('emails.contact-email', [
                'name'         => $data['name'],
                'email'        => $data['email'],
                'phone'        => $data['phone'] ?? 'Not provided',
                'user_message' => $message,
            ], function ($mail) use ($data) {
                $mail->from('info@zoikomobile.com', 'Zoiko Group');
                $mail->to('info@zoikomobile.com', 'Admin')
                     ->cc($data['email'])
                     ->replyTo($data['email'], $data['name'])
                     ->subject('Contact Us Message');
            });
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Contact-us email failed: ' . $e->getMessage(), ['contact_id' => $contact->id]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Thanks for contacting us.',
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
