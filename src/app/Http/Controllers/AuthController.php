<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\ContactRequest;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Contact::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", ["%{$search}%"])
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('gender') && $request->gender !== 'all') {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(7);

        $categories = [
            1 => '商品のお届けについて',
            2 => '商品の交換について',
            3 => '商品トラブル',
            4 => 'ショップへのお問い合わせ',
            5 => 'その他',
        ];

        return view('admin.index', compact('users', 'categories'));
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function reset()
    {
        return redirect()->route('admin.index');
    }

    public function delete($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.index');
    }

    public function export(Request $request)
    {

        $query = Contact::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", ["%{$search}%"])
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('gender') && $request->gender !== 'all') {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $contacts = $query->orderBy('created_at', 'desc')->get();

        $csvData = "お名前,性別,メールアドレス,お問い合わせの種類,お問い合わせ内容,作成日時\n";

        $categories = [
            1 => '商品のお届けについて',
            2 => '商品の交換について',
            3 => '商品トラブル',
            4 => 'ショップへのお問い合わせ',
            5 => 'その他',
        ];

        foreach ($contacts as $contact) {
            $name = ($contact->last_name ?? '') . ' ' . ($contact->first_name ?? '');
            $gender = $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : ($contact->gender == 3 ? 'その他' : '-'));
            $category = $categories[$contact->category_id] ?? '-';
            $content = str_replace(["\r\n", "\n", "\r"], ' ', $contact->detail ?? '');

            $csvData .= sprintf(
                '"%s","%s","%s","%s","%s","%s"' . "\n",
                $name,
                $gender,
                $contact->email ?? '',
                $category,
                $content,
                $contact->created_at->format('Y-m-d H:i:s')
            );
        }

        $bom = chr(0xEF) . chr(0xBB) . chr(0xBF);

        return Response::make($bom . $csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="contacts_' . date('YmdHis') . '.csv"',
        ]);
    }
}
