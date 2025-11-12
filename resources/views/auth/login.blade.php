<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body class="bg-light">
    <div class="container-fluid vh-100">
        <div class="row h-100">

            {{-- ✅ ซ้าย: กล่องล็อกอิน --}}
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <div class="login-card text-center px-5 py-4 shadow rounded-4" style="width: 80%; max-width: 420px;">

                    {{-- โลโก้ --}}
                    <div class="header-text mb-4">
                        <h1>เข้าสู่ระบบ</h1>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- ชื่อผู้ใช้งาน --}}
                        <div class="mb-3 text-start">
                            <div class="input-group">
                                <label for="username" class="input-group-text"><i class="bi bi-person"></i></label>
                                <input type="text" name="username" id="username" class="form-control"
                                    placeholder="อีเมล" required>
                            </div>
                        </div>

                        {{-- รหัสผ่าน --}}
                        <div class="mb-3 text-start">
                            <div class="input-group">
                                <label for="password" class="input-group-text"><i class="bi bi-lock"></i></label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="รหัสผ่าน" required>
                                <button type="button" class="btn btn-outline-light" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        {{-- สมัครสมาชิก --}}
                        <div class="d-flex justify-content-end mb-2 text-info">
                            ยังไม่มีบัญชี?<a href="/register" class="text-decoration-none">สมัครสมาชิก</a>
                        </div>

                        {{-- ปุ่มล็อกอิน --}}
                        <div class="my-2">
                            <button type="submit" class="btn-login-img border-0 bg-transparent">
                                <img src="{{ asset('img/Login/Login-Button.png') }}" alt="เข้าสู่ระบบ"
                                    class="img-fluid w-100">
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ✅ ขวา: พื้นหลังหรือรูปภาพ --}}
            <div class="col-md-6 d-none d-md-flex justify-content-end align-items-center pe-0">
                <img src="{{ asset('img/Login/Image (ชิดขวา).png') }}" alt="เข้าสู่ระบบ" class="img-fluid img-login-banner">
            </div>

        </div>
    </div>

    {{-- toggle password --}}
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        togglePassword.addEventListener('click', () => {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            togglePassword.innerHTML = type === 'password' ?
                '<i class="bi bi-eye"></i>' :
                '<i class="bi bi-eye-slash"></i>';
        });
    </script>
</body>

</html>
