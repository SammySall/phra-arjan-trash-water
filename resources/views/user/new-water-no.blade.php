@extends('layout.layout-user')
@section('title', 'New Registration')
@section('body-class', 'body-waterworks-bg')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/water-statistics.css') }}">
    <link rel="stylesheet" href="{{ asset('css/statistics-water.css') }}">
    <div class="container py-4">
        <div class="row">
            <div class="col-md-2">
                <a href="{{ url('/user/waterworks') }}">
                    <img src="{{ asset('img/new-registration/Back-Button.png') }}" alt="ปุ่มกลับ"
                        class="back-garbage-btn mb-4">
                </a>
            </div>

            <div class="col-md-10 bg-body-secondary p-4 rounded shadow-sm text-black d-flex">
                {{-- รูปด้านซ้าย --}}
                <div class="me-4 d-flex justify-content-center align-items-center" style="flex:0 0 30%;">
                    <img src="{{ asset('img/new-registration/Image-2.png') }}" alt="banner"
                        class="img-fluid rounded shadow-sm">
                </div>

                {{-- ฟอร์มด้านขวา --}}
                <div style="flex:1;">
                    <div class="mb-2 d-flex justify-content-center align-items-center">
                        <img src="{{ asset('img/new-registration/Image.png') }}" alt="banner"
                            class="img-fluid rounded shadow-sm">
                    </div>

                    <form id="registerWaterForm" action="{{ route('user.water_payment.register.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        {{-- แถว 1 --}}
                        <div class="row mb-3">
                            <div class="col-md-6 text-center">
                                <label class="label-box">ทะเบียนลูกค้า</label>
                                <input type="text" name="addon[waterNo]" class="form-control" required>
                            </div>
                            <div class="col-md-6 text-center">
                                <label class="label-box">ตั้งชื่อเรียกแทนเลขทะเบียน</label>
                                <input type="text" name="addon[name]" class="form-control" required>
                            </div>
                        </div>

                        {{-- แถว 2 --}}
                        <div class="row mb-3">
                            <div class="col-md-6 text-center">
                                <label class="label-box">สาขาที่ใช้น้ำ</label>
                                <input type="text" name="addon[branch]" class="form-control" required>
                            </div>
                            <div class="col-md-6 text-center">
                                <label class="label-box">ที่อยู่</label>
                                <input type="text" name="addon[address]" class="form-control"
                                    placeholder="เช่น บ้านเลขที่ หมู่บ้าน ตำบล อำเภอ จังหวัด" required>
                            </div>
                        </div>

                        <button type="submit"
                            class="btn btn-primary w-100 add-water-no d-flex justify-content-center align-items-center">
                            <i class="bi bi-plus icon-plus"></i>เพิ่มทะเบียนลูกค้า
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert2 + Ajax --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('registerWaterForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                const data = await res.json();

                if (res.ok && data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'ลงทะเบียนสำเร็จ',
                        text: data.message || 'คุณได้ลงทะเบียนเรียบร้อยแล้ว',
                        confirmButtonText: 'ตกลง'
                    }).then(() => {
                        window.location.href = "{{ url('/user/waterworks') }}";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: data.message || 'ไม่สามารถบันทึกข้อมูลได้'
                    });
                }
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้'
                });
            }
        });
    </script>
@endsection
