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

        // 電話番号を文字列化
        if (isset($contact['tel']) && is_array($contact['tel'])) {
            $contact['tel'] = implode('', $contact['tel']);
        }

        // 性別ラベルを追加
        $genderLabels = [1 => '男性', 2 => '女性', 3 => 'その他'];
        $contact['gender_label'] = $genderLabels[$contact['gender']] ?? '-';

        // お問い合わせ種類ラベルを追加
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
        // $contact = $request->only(['category_id','last_name','first_name','gender','email', 'tel','address','building','detail']);
        // Contact::create($contact);
    // セッションから値を取得
    $contact = session('contact_input');

    // DBに保存する場合は数字のまま
    Contact::create([
        'category_id' => $contact['category_id'], // 数字のまま
        'last_name' => $contact['last_name'],
        'first_name' => $contact['first_name'],
        'gender' => $contact['gender'],           // 数字のまま
        'email' => $contact['email'],
        'tel' => $contact['tel'],
        'address' => $contact['address'],
        'building' => $contact['building'],
        'detail' => $contact['detail'],
    ]);

    // セッションは削除しても良い
    $request->session()->forget('contact_input');
        return view('/contact/thanks');




    }
}
