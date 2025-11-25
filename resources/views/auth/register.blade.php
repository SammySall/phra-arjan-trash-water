<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="body-bg">
    <div class="container-fluid vh-100">
        <div class="row h-100">

            <!-- ซ้าย -->
            <div class="col-12 col-lg-6 d-flex flex-column justify-content-center align-items-center">
                <div class="p-3 w-100" style="max-width: 600px;">

                    <form method="POST" action="{{ route('register.store') }}"
                        class="row g-3 mx-3 d-flex flex-column justify-content-center align-items-center">
                        @csrf

                        <div class="form-bg col-12">

                            <!-- Header -->
                            <div class="header-text mb-3 text-center d-flex justify-content-center align-items-center">
                                <img src="../img/register/Icon.png" alt="รูปคน" class="img-fluid me-2"
                                    style="max-width: 100px;">
                                <h3 class="mt-2">ลงทะเบียน</h3>
                            </div>

                            <!-- Error Global -->
                            @if ($errors->any())
                                <div class="alert alert-danger mt-2">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- เลือก Email / Phone -->
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label d-block">ชื่อผู้ใช้</label>

                                    <div class="d-flex align-items-center mb-2">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="login_type"
                                                id="radio_email" value="email" checked>
                                            <label class="form-check-label" for="radio_email">ใช้อีเมล</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="login_type"
                                                id="radio_phone" value="phone">
                                            <label class="form-check-label" for="radio_phone">ใช้เบอร์โทรศัพท์</label>
                                        </div>
                                    </div>

                                    <small id="email_hint" class="text-danger d-none">example@example.com</small>

                                    <input type="email" name="email" id="input_email" class="form-control mt-1"
                                        placeholder="กรอกอีเมลของคุณ" value="{{ old('email') }}">

                                    <input type="tel" id="input_phone" class="form-control mt-2 d-none"
                                        maxlength="10" placeholder="กรอกเบอร์โทรศัพท์ 10 หลัก"
                                        value="{{ old('phone') }}">
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="row mt-2">
                                <div class="col-12 col-md-6">
                                    <label for="password" class="form-label">รหัสผ่าน</label>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="confirm" class="form-label">ยืนยันรหัสผ่าน</label>
                                    <input type="password" name="password_confirmation" id="confirm"
                                        class="form-control">
                                </div>
                            </div>

                            <!-- คำนำหน้า + ชื่อ -->
                            <div class="row mt-2">
                                <div class="col-12 col-md-6">
                                    <label for="salutation" class="form-label">คำนำหน้า</label>
                                    <select class="form-select" id="salutation" name="salutation">
                                        <option value="" disabled selected>เลือกคำนำหน้า</option>
                                        <option value="นาย">นาย</option>
                                        <option value="นาง">นาง</option>
                                        <option value="นางสาว">นางสาว</option>
                                    </select>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="name" class="form-label">ชื่อ-นามสกุล</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name') }}">
                                </div>
                            </div>

                            <!-- อายุ / โทร -->
                            <div class="row mt-2">
                                <div class="col-12 col-md-6">
                                    <label for="age" class="form-label">อายุ</label>
                                    <input type="number" name="age" id="age" class="form-control"
                                        value="{{ old('age') }}">
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="tel" class="form-label">เบอร์โทรศัพท์</label>
                                    <input type="tel" name="tel" id="tel" class="form-control"
                                        maxlength="10" value="{{ old('tel') }}">
                                </div>
                            </div>

                            <!-- ที่อยู่ -->
                            <div class="mt-2">
                                <label for="address" class="form-label">ที่อยู่</label>
                                <textarea name="address" id="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                            </div>

                            <!-- จังหวัด / อำเภอ / ตำบล -->
                            <div class="row mt-2">
                                <div class="col-12 col-md-4">
                                    <label for="province" class="form-label">จังหวัด</label>
                                    <input type="text" class="form-control" id="province" name="province"
                                        value="{{ old('province') }}">
                                </div>

                                <div class="col-12 col-md-4">
                                    <label for="district" class="form-label">อำเภอ</label>
                                    <input type="text" class="form-control" id="district" name="district"
                                        value="{{ old('district') }}">
                                </div>

                                <div class="col-12 col-md-4">
                                    <label for="subdistrict" class="form-label">ตำบล</label>
                                    <input type="text" class="form-control" id="subdistrict" name="subdistrict"
                                        value="{{ old('subdistrict') }}">
                                </div>
                            </div>

                            <!-- ปุ่ม -->
                            <div class="mt-3 text-center">
                                <div class="mt-2">
                                    มีบัญชีแล้ว?
                                    <a href="/login" class="text-danger text-decoration-none">เข้าสู่ระบบ</a>
                                </div>

                                <button type="submit" class="btn w-100 p-2">
                                    <img src="../img/register/Register-Button.png" alt="button"
                                        class="img-fluid w-100">
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <!-- ขวา -->
            <div class="col-md-6 d-none d-md-flex justify-content-end align-items-center pe-0">
                <img src="{{ asset('img/Login/Image (ชิดขวา).png') }}" alt="เข้าสู่ระบบ"
                    class="img-fluid img-login-banner">
            </div>

        </div>
    </div>

    <!-- JavaScript: toggle email/phone -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const radioEmail = document.getElementById('radio_email');
            const radioPhone = document.getElementById('radio_phone');
            const inputEmail = document.getElementById('input_email');
            const inputPhone = document.getElementById('input_phone');
            const emailHint = document.getElementById('email_hint');

            function toggleInput() {
                if (radioEmail.checked) {
                    inputEmail.classList.remove('d-none');
                    inputEmail.setAttribute('name', 'email');

                    inputPhone.classList.add('d-none');
                    inputPhone.removeAttribute('name');

                    emailHint.classList.remove('d-none');
                } else {
                    inputPhone.classList.remove('d-none');
                    inputPhone.setAttribute('name', 'phone');

                    inputEmail.classList.add('d-none');
                    inputEmail.removeAttribute('name');

                    emailHint.classList.add('d-none');
                }
            }

            radioEmail.addEventListener('change', toggleInput);
            radioPhone.addEventListener('change', toggleInput);
            toggleInput();
        });
    </script>

    <!-- Success Alert -->
    @if (session('success') && !$errors->any())
        <script>
            Swal.fire({
                icon: 'success',
                title: 'สมัครสมาชิกสำเร็จ!',
                text: '{{ session('success') }}',
                confirmButtonText: 'เข้าสู่ระบบ',
                confirmButtonColor: '#d33'
            }).then(() => {
                window.location.href = '/login';
            });
        </script>
    @endif

</body>

</html>
