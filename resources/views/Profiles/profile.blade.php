@extends('Profiles.layouts')
@section  ('content')
<section class="profile-info-section main-padding">
  <div class="container">
    <div class="profile-info-container">
        <div class="profile-info-box">
          <p class="profile-info-title">نبذة مختصرة </p>
          @if ($profile->bio == null)
          <p class="profile-info-text">........</p>
          @else
          <p class="profile-info-text">{{$profile->bio}}</p>
          @endif
        </div>
      </div>
      <div class="profile-info-container">
        <div class="profile-info-box">
          <p class="profile-info-title">الاهتمامات </p>
          @if ($profile->inetrests == null)
          <p class="profile-info-text">........</p>
          @else
          <p class="profile-info-text">{{$profile->inetrests}}</p>
          @endif
        </div>
      </div>

    <div class="profile-info-container">

      <div class="profile-info-box">
        <p class="profile-info-title">الكتب المُنشأة </p>
        <div class="books-in-profile-box">
          <div class="swiper mySwiper">
            <div class="swiper-wrapper">
              @foreach($user['groups'] as $group)
              @if ($group->pivot->group_user_role == "admin")
                <div class="swiper-slide">
                  <div class="col"><a class="card customized-card" href="/book-page/{{$group->id}}">
                      <div class="card-img-box"><img class="card-img-top" src="/images/{{$group->image}}" alt="art"></div>
                      <div class="card-body">
                        <h5 class="card-title">{{$group->name}}</h5>
                      </div></a></div>
                </div>
              @endif
              @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="profile-info-container">
      <div class="profile-info-box">
        <p class="profile-info-title">الكتب المُنضم لها </p>
        <div class="books-in-profile-box">
          <div class="swiper mySwiper">
            <div class="swiper-wrapper">
              @foreach ($user["groups"] as $group)
              @if ($group->pivot->group_user_role == "member")
                <div class="swiper-slide">
                  <div class="col"><a class="card customized-card" href="/book-page/{{$group->id}}">
                      <div class="card-img-box"><img class="card-img-top" src="/images/{{$group->image}}" alt="art"></div>
                      <div class="card-body">
                        <h5 class="card-title">{{$group->name}}</h5>
                      </div></a></div>
                </div>
              @endif
              @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('profile-info-active')
<div class="profile-links-box">
  <h2 class="parson-name">{{$user->name}}</h2>
  <ul>
    <li class="profile-type-link"><a href="/profile-info/{{$user->id}}">بيانات الحساب</a></li>
  </ul>
</div>
@endsection
