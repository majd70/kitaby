@extends('Profiles.layouts')
@section  ('content')
<section class="profile-content-section main-padding">
  <div class="container">
    <div class="account-details-box">
      <h4 class="account-details-title">بيانات عامة</h4>
      <form class="account-details-form" action = '/general-info/{{$profile->id}}' method="POST">
        @csrf
        <div class="edit-account-brief">
          <label for="#brief">نبذة مختصرة</label>
          <textarea class="account-brief-text" name = 'bio' id="brief" placeholder="نبذة قصيرة عنك"  required>{{$profile->bio}}</textarea>
        </div>
        <div class="interests edit-account-brief">
          <label for="#interests">الاهتمامات</label>
          <textarea class="account-interests-text account-brief-text" name = 'inetrests' id="interests" placeholder="الاهتمامات" required>{{$profile->inetrests}}</textarea>
        </div>
        <div class="form-btn-box">
              <button class="global-btn-box swal-button" type="submit">حفظ التعديلات</button>
        </div>
      </form>
    </div>
    {{-- <div class="account-details-box">
      <h4 class="account-details-title">بيانات خاصة</h4>
      <form class="account-details-form">
        <div class="form-row">
              <div class="global-input-box d-flex flex-column">
                <label for="accountName">الاسم الكامل</label>
                <input type="text" id="accountName" placeholder="الاسم الكامل">
              </div>
              <div class="global-input-box d-flex flex-column">
                <label for="accountDateOfBirth">تاريخ الميلاد</label>
                <input type="text" id="accountDateOfBirth" placeholder="03/01/1997">
              </div>
        </div>
        <div class="form-row">
              <div class="global-input-box d-flex flex-column">
                <label for="accountEmail">البريد الالكتروني</label>
                <input type="text" id="accountEmail" placeholder="example@gmail.com">
              </div>
              <div class="global-input-box d-flex flex-column">
                <label for="accountPhoneNumber">رقم الهاتف</label>
                <input type="text" id="accountPhoneNumber" placeholder="+966 7845 783">
              </div>
        </div>
        <div class="form-row">
              <div class="global-input-box d-flex flex-column">
                <label for="accountCountry">الدولة</label>
                <input type="text" id="accountCountry" placeholder="فلسطين">
              </div>
              <div class="global-input-box d-flex flex-column">
                <label for="accountAddress">العنوان</label>
                <input type="text" id="accountAddress" placeholder="غزة - النصيرات">
              </div>
        </div>
        <div class="form-btn-box">
              <button class="global-btn-box swal-button" type="button">حفظ التعديلات</button>
        </div>
      </form>
    </div> --}}
    {{-- <div class="account-details-box">
      <h4 class="account-details-title">كلمة المرور</h4>
      <form class="account-details-form">
        <div class="form-row">
              <div class="global-input-box d-flex flex-column">
                <label for="accountOldPassword">كلمة المرور القديمة</label>
                <input type="password" id="accountOldPassword" placeholder="اكتب هنا...">
              </div>
              <div class="global-input-box d-flex flex-column">
                <label for="accountNewPassword">كلمة المرور الجديدة</label>
                <input type="password" id="accountNewPassword" placeholder="اكتب هنا...">
              </div>
        </div>
        <div class="form-btn-box">
              <button class="global-btn-box swal-button" type="button">تغيير الكلمة</button>
        </div>
      </form>
    </div> --}}
  </div>
</section>
@endsection

@section('profile-info-active')
<div class="profile-links-box">
  <h2 class="parson-name">{{$user->name}}</h2>
  <ul>
    <li class="profile-type-link active"><a href="/profile-info/{{$user->id}}">بيانات الحساب</a></li>
  </ul>
</div>
@endsection
