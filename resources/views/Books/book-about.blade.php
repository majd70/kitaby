@extends('Books.layouts')

@section('book-bar')
<div class="book-pages-bar"> <a class="book-bar-links" href="/book-page/{{$group->id}}">حوار</a>
  <a class="book-bar-links" href="/book-member/{{$group->id}}">الأعضاء</a>
  <a class="book-bar-links active" href="">عن الكتاب</a>
</div>

@endsection

@section('content')
<section class="members-section about-book-section"> 
  <div class="small-container"> 
    <div class="members-content about-book-content">
      <div class="about-book-text-box">
        <h2 class="about-book-subtitle">نبذة</h2>
        <p>{{$group->description}}</p>
      </div>
    </div>
    <div class="members-content about-book-content">
      <div class="about-book-text-box">
        <h2 class="about-book-subtitle">الأنشطة</h2>
      </div>
      <div class="members-subtitle-box d-flex align-items-center justify-content-start m-0 mt-3">
        <h2 class="members-subtitle m-0">المشرفون</h2>
        <p class="members-title-dot m-0"> </p>
        <p class="members-number m-0">{{count($admins_name)}}</p>
      </div>
      @foreach ($admins_name as $admin)
      <div class="member-box pb-3">
        <div class="member-img-box"> <a href="/profile/{{$admin->id}}">  
          @foreach ($profiles as $profile)
          @if ($profile->user_id == $admin->id)        
          <img src="/profile-images/{{$profile->image}}" alt="member image">
          @endif
          @endforeach

        </a></div>
        <div class="member-info"> <a class="member-link" href="/profile/{{$admin->id}}">
            <p>{{$admin->name}}</p></a></div>
      </div>
      @endforeach
      <div class="members-subtitle-box d-flex align-items-center justify-content-start"> 
        <div class="members-img-box"> <img src="../assets/images/members.png" alt="members"></div>
        <p class="members-subtitle m-0">الأعضاء</p>
        <p class="members-title-dot m-0"> </p>
        <p class="members-number m-0">{{$members}}</p>
      </div>
      <div class="members-subtitle-box d-flex align-items-center justify-content-start"> 
        <div class="members-img-box"> <img src="../assets/images/history.png" alt="history"></div>
        <p class="members-subtitle m-0"> الإنشاء</p>
        <p class="members-title-dot m-0"> </p>
        <p class="members-number history-box d-flex m-0"><span>منذ</span><span>{{$group->created_at}}</span><span>###</span></p>
      </div>
    </div>
  </div>
</section>
@endsection