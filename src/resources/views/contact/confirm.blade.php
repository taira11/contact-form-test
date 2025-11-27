<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Form</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/confirm.css') }}" />
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
                 FashionablyLate
            </a>
        </div>
    </header>
    <main>
        <div class="confirm__content">
            <div class="confirm__heading">
                <h2>confirm</h2>
            </div>
            <form class="form" action="/contacts" method="post">
                @csrf
                <div class="confirm-table">
                    <table class="confirm-table__inner">
                        <tr class="confirm-table__row">
                            <th class="confirm-table__header">お名前</th>
                            <td class="confirm-table__text">
                                <input class="confirm-table__text--name" type="text" name="last_name" value="{{ $contact['last_name'] }}" readonly />
                                <input class="confirm-table__text--name" type="text" name="first_name" value="{{ $contact['first_name'] }}" readonly />
                            </td>
                        </tr>
                        <tr class="confirm-table__row">
                            <th class="confirm-table__header">性別</th>
                            <td class="confirm-table__text">
                                <input type="text" name="gender" value="{{ $contact['gender_label'] }}" readonly />
                            </td>
                        </tr>
                        <tr class="confirm-table__row">
                            <th class="confirm-table__header">メールアドレス</th>
                            <td class="confirm-table__text">
                                <input type="email" name="email" value="{{ $contact['email'] }}" readonly />
                            </td>
                        </tr>
                        <tr class="confirm-table__row">
                            <th class="confirm-table__header">電話番号</th>
                            <td class="confirm-table__text">
                                <input type="tel" name="tel" value="{{ $contact['tel'] }}" readonly />
                            </td>
                        </tr>
                        <tr class="confirm-table__row">
                            <th class="confirm-table__header">住所</th>
                            <td class="confirm-table__text">
                                <input type="text" name="address" value="{{ $contact['address'] }}" readonly />
                            </td>
                        </tr>
                        <tr class="confirm-table__row">
                            <th class="confirm-table__header">建物名</th>
                            <td class="confirm-table__text">
                                <input type="text" name="building" value="{{ $contact['building'] }}" readonly />
                            </td>
                        </tr>
                        <tr class="confirm-table__row">
                            <th class="confirm-table__header">お問い合わせの種類</th>
                            <td class="confirm-table__text">
                                <input type="text" name="category_id" value="{{ $contact['category_label'] }}"readonly />
                            </td>
                        </tr>
                        <tr class="confirm-table__row">
                            <th class="confirm-table__header">お問い合わせ内容</th>
                            <td class="confirm-table__text">
                                <input type="text" name="detail" value="{{ $contact['detail'] }}" readonly />
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
            <div class="button-container">
                <form action="/contacts" method="POST">
                    @csrf
                    <input type="hidden" name="last_name" value="{{ $contact['last_name'] }}">
                    <input type="hidden" name="first_name" value="{{ $contact['first_name'] }}">
                    <input type="hidden" name="gender" value="{{ $contact['gender_label'] }}" >
                    <input type="hidden" name="email" value="{{ $contact['email'] }}">
                    <input type="hidden" name="tel" value="{{ $contact['tel'] }}">
                    <input type="hidden" name="address" value="{{ $contact['address'] }}" >
                    <input type="hidden" name="building" value="{{ $contact['building'] }}">
                    <input type="hidden" name="category_id" value="{{ $contact['category_label'] }}">
                    <input type="hidden" name="detail" value="{{ $contact['detail'] }}">
                    <button type="submit" class="form__button-submit">送信</button>
                </form>
                <form action="{{ route('contact.index') }}" method="GET">
                    <input type="hidden" name="last_name" value="{{ $contact['last_name'] }}">
                    <input type="hidden" name="first_name" value="{{ $contact['first_name'] }}">
                    <input type="hidden" name="gender" value="{{ $contact['gender'] }}" >
                    <input type="hidden" name="email" value="{{ $contact['email'] }}">
                    <input type="hidden" name="tel[]" value="{{ $contact['tel'][0] }}">
                    <input type="hidden" name="tel[]" value="{{ $contact['tel'][1] }}">
                    <input type="hidden" name="tel[]" value="{{ $contact['tel'][2] }}">
                    <input type="hidden" name="address" value="{{ $contact['address'] }}" >
                    <input type="hidden" name="building" value="{{ $contact['building'] }}">
                    <input type="hidden" name="category_id" value="{{ $contact['category_id'] }}">
                    <input type="hidden" name="detail" value="{{ $contact['detail'] }}">
                    <button type="submit" class="form__button-correction">修正</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
