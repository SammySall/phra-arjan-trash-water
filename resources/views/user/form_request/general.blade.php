@extends('layout.layout-request')
@section('title', 'คำร้องขอทั่วไป')
@section('request-header-img','general')
@section('request-header', 'คำร้องขอทั่วไป')
@section('request-content')
    <div class="list-group">
        <form>
            <input type="hidden" name="_token" value="pkSJvo0JuQW0qX50gaX8MSHMadLn3vxDC2etGkd1" autocomplete="off">

            <div class="mb-3">
                <label class="form-label">วันที่</label>
                <input type="text" name="field_date" class="form-control" value="18 ตุลาคม 2568" readonly="">
            </div>


            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="prefix" class="form-label">คำนำหน้า<span class="text-danger">*</span></label>
                    <select id="prefix" name="field_1" class="form-control" required="">
                        <option value="">-- โปรดเลือก --</option>
                        <option value="นาย">นาย</option>
                        <option value="นาง">นาง</option>
                        <option value="นางสาว">นางสาว</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="name" class="form-label">ชื่อ - นามสกุล<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_2" id="name" required="">
                </div>
                <div class="col-md-3">
                    <label for="tel" class="form-label">เบอร์โทร<span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" name="field_3" id="tel" pattern="[0-9]{10}"
                        maxlength="10" required="">
                </div>
            </div>


            <div class="mb-3 mt-3">
                <label for="subject" class="form-label">เรื่อง<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="field_4" id="subject" required="">
            </div>

            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">อายุ<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_5" required="">
                </div>
                <div class="col-md-3">
                    <label class="form-label">สัญชาติ<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_6" required="">
                </div>
                <div class="col-md-3">
                    <label class="form-label">บ้านเลขที่<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_7" required="">
                </div>
            </div>

            <div class="row g-3 mt-3">

                <div class="col-md-3">
                    <label class="form-label">หมู่ที่<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_8" required="">
                </div>
                <div class="col-md-3">
                    <label class="form-label">แขวง/ตำบล<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_9" required="">
                </div>
                <div class="col-md-3">
                    <label class="form-label">เขต/อำเภอ<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_10" required="">
                </div>
                <div class="col-md-3">
                    <label class="form-label">จังหวัด<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_11" required="">
                </div>
            </div>

            <div class="mb-3 mt-3">
                <label class="form-label">ขอยื่นคำดังต่อไปนี้</label>
                <textarea class="form-control" name="field_12" rows="3"></textarea>
            </div>


            <div class="mb-3">
                <label class="form-label">พร้อมนี้ได้แนบเอกสารหลักฐานมาด้วย จำนวน</label>
                <input type="number" name="field_13" class="form-control d-inline-block" style="width: 80px;"
                    max="5"> ฉบับ
            </div>


            <div class="mb-3">
                <label class="form-label">ไฟล์แนบ</label>
                <input type="file" id="files" name="files[]" class="form-control"
                    accept=".doc,.docx,.pdf,.xls,.xlsx" multiple="">
                <small class="text-muted">รองรับเฉพาะ .doc, .docx, .pdf, .xls, .xlsx, .png, .jpeg สูงสุด 5
                    ไฟล์</small>
            </div>


            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-5">บันทึก</button>
            </div>
        </form>
    </div>
@endsection
