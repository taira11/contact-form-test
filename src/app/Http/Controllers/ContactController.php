<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Response;

class ContactController extends Controller
{
    public function index()
    {
        return view('/contact/form');
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->only([
            'category_id','last_name','first_name','gender','email','tel','address','building','detail'
        ]);

        if (isset($contact['tel']) && is_array($contact['tel'])) {
            $contact['tel'] = implode('', $contact['tel']);
        }

        $genderLabels = [1 => '男性', 2 => '女性', 3 => 'その他'];
        $contact['gender_label'] = $genderLabels[$contact['gender']] ?? '-';

        $categoryLabels = [
            1 => '商品のお届けについて',
            2 => '商品交換について',
            3 => '商品トラブル',
            4 => 'ショップへのお問い合わせ',
            5 => 'その他'
        ];
        $contact['category_label'] = $categoryLabels[$contact['category_id']] ?? '-';

        session(['contact_input' => $contact]);

        return view('contact.confirm', compact('contact'));
    }

    public function store(Request $request)
    {
    $contact = session('contact_input');

    Contact::create([
        'category_id' => $contact['category_id'],
        'last_name' => $contact['last_name'],
        'first_name' => $contact['first_name'],
        'gender' => $contact['gender'],
        'email' => $contact['email'],
        'tel' => $contact['tel'],
        'address' => $contact['address'],
        'building' => $contact['building'],
        'detail' => $contact['detail'],
    ]);

    $request->session()->forget('contact_input');
        return view('/contact/thanks');
    }
}
