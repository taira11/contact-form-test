<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Form</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
</head>
<body>
    <header>
        <div class="header-content">
            <h1 class="site-title">FashionablyLate</h1>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="logout-btn">logout</button>
        </form>
        </div>
    </header>
    <main>
        <h2 class="admin-title">Admin</h2>
        <form method="GET" action="{{ route('admin.search') }}">
            <div class="filter-section">
                <input type="text" name="search" class="filter-input search-input" placeholder="名前やメールアドレスを入力してください" value="{{ request('search') }}">
                <select name="gender" class="filter-input gender-select">
                    <option value="">性別</option>
                    <option value="all" {{ request('gender') == 'all' ? 'selected' : '' }}>全て</option>
                    <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
                    <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
                    <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
                </select>
                <select name="category" class="filter-input category-input">
                    <option value="">お問い合わせの種類</option>
                    @if(isset($categories))
                        @foreach($categories as $id => $name)
                            <option value="{{ $id }}" {{ request('category') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    @endif
                </select>
                <input type="date" name="date" class="filter-input date-input" value="{{ request('date') }}">
                <button type="submit" class="search-btn">検索</button>
                <a href="{{ route('admin.reset') }}" class="reset-btn" style="text-decoration: none; display: inline-block; line-height: 1.5;">リセット</a>
            </div>
        </form>

        <div class="table-controls">
            <a href="/export?{{ http_build_query(request()->all()) }}" class="export-btn">エクスポート</a>
            <div class="pagination">
                @if($users->onFirstPage())
                    <span class="page-nav" style="cursor: not-allowed; opacity: 0.5;">&lt;</span>
                @else
                    <a href="{{ $users->previousPageUrl() }}&{{ http_build_query(request()->except('page')) }}" class="page-nav">&lt;</a>
                @endif

                @if($users->lastPage() > 1)
                    @php
                        $currentPage = $users->currentPage();
                        $lastPage = $users->lastPage();

                        // 表示するページ番号の範囲を計算
                        $startPage = max(1, $currentPage - 2);
                        $endPage = min($lastPage, $startPage + 4);

                        // 5ページ未満の場合、開始ページを調整
                        if ($endPage - $startPage < 4) {
                            $startPage = max(1, $endPage - 4);
                        }
                    @endphp

                    @for($page = $startPage; $page <= $endPage; $page++)
                        @if($page == $users->currentPage())
                            <span class="page-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $users->url($page) }}&{{ http_build_query(request()->except('page')) }}" class="page-btn">{{ $page }}</a>
                        @endif
                    @endfor
                @else
                    <span class="page-btn active">1</span>
                @endif

                @if($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}&{{ http_build_query(request()->except('page')) }}" class="page-nav">&gt;</a>
                @else
                    <span class="page-nav" style="cursor: not-allowed; opacity: 0.5;">&gt;</span>
                @endif
            </div>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>お名前</th>
                    <th>性別</th>
                    <th>メールアドレス</th>
                    <th>お問い合わせの種類</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if(isset($users) && $users->count() > 0)
                    @foreach($users as $user)
                    <tr>
                        <td>{{ ($user->last_name ?? '') . ' ' . ($user->first_name ?? '') }}</td>
                        <td>
                            @if(isset($user->gender))
                                @if($user->gender == 1)
                                    男性
                                @elseif($user->gender == 2)
                                    女性
                                @elseif($user->gender == 3)
                                    その他
                                @else
                                    -
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if(isset($user->category_id) && isset($categories[$user->category_id]))
                                {{ $categories[$user->category_id] }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <button class="detail-btn" onclick="openModal({{ $user->id }},
                                '{{ addslashes(($user->last_name ?? '') . ' ' . ($user->first_name ?? '')) }}',
                                '{{ $user->gender == 1 ? '男性' : ($user->gender == 2 ? '女性' : ($user->gender == 3 ? 'その他' : '-')) }}',
                                '{{ $user->email }}',
                                '{{ $user->tel ?? '-' }}',
                                '{{ $user->address ?? '-' }}',
                                '{{ $user->building ?? '-' }}',
                                '{{ isset($categories[$user->category_id]) ? addslashes($categories[$user->category_id]) : '-' }}',
                                '{{ addslashes($user->detail ?? '-') }}'
                            )">詳細</button>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; border-right: none;">
                            登録されたユーザーがいません
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </main>
    <div id="detailModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="modal-row">
                    <div class="modal-label">お名前</div>
                    <div class="modal-value" id="modal-name"></div>
                </div>
                <div class="modal-row">
                    <div class="modal-label">性別</div>
                    <div class="modal-value" id="modal-gender"></div>
                </div>
                <div class="modal-row">
                    <div class="modal-label">メールアドレス</div>
                    <div class="modal-value" id="modal-email"></div>
                </div>
                <div class="modal-row">
                    <div class="modal-label">電話番号</div>
                    <div class="modal-value" id="modal-tel"></div>
                </div>
                <div class="modal-row">
                    <div class="modal-label">住所</div>
                    <div class="modal-value" id="modal-address"></div>
                </div>
                <div class="modal-row">
                    <div class="modal-label">建物名</div>
                    <div class="modal-value" id="modal-building"></div>
                </div>
                <div class="modal-row">
                    <div class="modal-label">お問い合わせの種類</div>
                    <div class="modal-value" id="modal-category"></div>
                </div>
                <div class="modal-row">
                    <div class="modal-label">お問い合わせ内容</div>
                    <div class="modal-value" id="modal-detail"></div>
                </div>
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn">削除</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        let currentContactId = null;

        function openModal(id, name, gender, email, tel, address, building, category, detail) {
            currentContactId = id;

            document.getElementById('modal-name').textContent = name;
            document.getElementById('modal-gender').textContent = gender;
            document.getElementById('modal-email').textContent = email;
            document.getElementById('modal-tel').textContent = tel;
            document.getElementById('modal-address').textContent = address;
            document.getElementById('modal-building').textContent = building || '-';
            document.getElementById('modal-category').textContent = category;
            document.getElementById('modal-detail').textContent = detail;

            document.getElementById('deleteForm').action = '/admin/delete/' + id;
            document.getElementById('detailModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('detailModal').classList.remove('active');
        }

        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>
</html>