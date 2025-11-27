<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Form</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
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
        <div class="contact-form__content">
            <div class="contact-form__heading">
                <h2>Contact</h2>
            </div>
            <form class="form" action="/confirm" method="post">
                @csrf
                <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label--item">お名前</span>
                        <span class="form__label--required">※</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="text" name="last_name" placeholder="(例)山田" value="{{ old('last_name', session('contact_input.last_name', '')) }}" />
                            <input type="text" name="first_name" placeholder="(例)太郎"  value="{{ old('first_name', session('contact_input.first_name', '')) }}" />
                        </div>
                        <div class="form__error">
                            @error('last_name')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                            @error('first_name')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label--item">性別</span>
                        <span class="form__label--required">※</span>
                    </div>
                    <div class="form__group-content--gender">
                        <div class="form__input--title">
                            <!-- <input type="radio" name="gender" value="1" {{ old('gender', session('contact_input.gender', '')) == 1 ? 'selected' : '' }}><label>男性</label>
                            <input type="radio" name="gender" value="2" {{ old('gender', session('contact_input.gender', '')) == 2 ? 'selected' : '' }}><label>女性</label>
                            <input type="radio" name="gender" value="3" {{ old('gender', session('contact_input.gender', '')) == 3 ? 'selected' : '' }}> <label>その他</label> -->
                            @php
                            $genderValue = request('gender', old('gender', session('contact_input.gender')));
                            @endphp
                            <label><input type="radio" name="gender" value="1" {{ $genderValue == '1' ? 'checked' : '' }}>男性</label>
                            <label><input type="radio" name="gender" value="2" {{ $genderValue == '2' ? 'checked' : '' }}>女性</label>
                            <label><input type="radio" name="gender" value="3" {{ $genderValue == '3' ? 'checked' : '' }}>その他</label>
                        </div>
                        <div class="form__error--gender">
                            @error('gender')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label--item">メールアドレス</span>
                        <span class="form__label--required">※</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="email" name="email" placeholder="test@example.com" value="{{ old('email', session('contact_input.email', '')) }}"/>
                        </div>
                        <div class="form__error">
                            @error('email')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label--item">電話番号</span>
                        <span class="form__label--required">※</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="text" name="tel[]" placeholder="000" value="{{ old('tel.0', session('contact_input.tel.0', '')) }}"><label>-</label>
                            <input type="text" name="tel[]" placeholder="1234" value="{{ old('tel.1', session('contact_input.tel.1', '')) }}"><label>-</label>
                            <input type="text" name="tel[]" placeholder="5678" value="{{ old('tel.2', session('contact_input.tel.2', '')) }}">
                        </div>
                        <div class="form__error">
                            @error('tel*')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label--item">住所</span>
                        <span class="form__label--required">※</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="text" name="address" placeholder="例）東京都渋谷区○○3-2-1" value="{{ old('address',session('contact_input.address', '')) }}">
                        </div>
                        <div class="form__error">
                            @error('address')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label--item">建物名</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="text" name="building" placeholder="例:千駄ヶ谷マンション101" value="{{ old('building',session('contact_input.building', '')) }}"  >
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label--item">お問い合わせの種類</span>
                        <span class="form__label--required">※</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <select name="category_id">
                                <option value="">選択してください</option>
                                <option value="1" {{ old('category_id', session('contact_input.category_id', '')) == 1 ? 'selected' : '' }}>1. 商品のお届けについて</option>
                                <option value="2" {{ old('category_id', session('contact_input.category_id', '')) == 2 ? 'selected' : '' }}>2. 商品の交換について</option>
                                <option value="3" {{ old('category_id', session('contact_input.category_id', '')) == 3 ? 'selected' : '' }}>3. 商品トラブル</option>
                                <option value="4" {{ old('category_id', session('contact_input.category_id', '')) == 4 ? 'selected' : '' }}>4. ショップへのお問い合わせ</option>
                                <option value="5" {{ old('category_id', session('contact_input.category_id', '')) == 5 ? 'selected' : '' }}>5. その他</option>
                            </select>
                        </div>
                        <div class="form__error">
                            @error('category_id')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label--item">お問い合わせ内容</span>
                        <span class="form__label--required">※</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--textarea">
                            <textarea name="detail" placeholder="お問い合わせ内容をご記載ください">{{ old('detail',session('contact_input.detail','')) }}</textarea>
                        </div>
                        <div class="form__error">
                            @error('detail')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__button">
                    <button class="form__button-submit" type="submit">確認画面</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
