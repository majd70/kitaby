<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-DOXMLfHhQkvFFp+rWTZwVlPVqdIhpDVYT9csOnHSgWQWPX0v5MCGtjCJbY6ERspU" crossorigin="anonymous">
    <link rel="stylesheet" href={{ asset('assets/css/style.css')}}>
    <title>إنشاء حساب</title>
  </head>
  <body>
    <main class="log-main">
      <div class="d-grid log-page-layout">
        <div class="log-box">
          <div class="log-box-style">
            <h1 class="log-title">إنشاء حساب</h1>
            <form class="log-form" action="">
                {{-- <a href="" class="log-btn facebook-btn">
                  <span>التسجيل باستخدام فيسبوك</span>
                  <svg>
                    <use href="{{ asset('/assets/images/icons/icons.svg#facebook') }}"></use>
                  </svg>
                </a>
                <a href="{{ route('auth.socilaite.redirect','google') }}" class="log-btn google-btn">
                  <span>التسجيل باستخدام جوجل</span>
                  <svg>
                    <use href="{{ asset('/assets/images/icons/icons.svg#google') }}"></use>
                  </svg>
                </a> --}}
                <button type="submit" formaction="{{ route('auth.socilaite.redirect','facebook') }}" class="button log-btn facebook-btn">
                  <span>الدخول باستخدام فيسبوك</span>
                  <svg>
                    <use href="{{ asset('/assets/images/icons/icons.svg#facebook') }}"></use>
                  </svg>
                </button>
                <button type="submit" formaction="{{ route('auth.socilaite.redirect','google') }}" class="button log-btn google-btn">
                  <span>الدخول باستخدام جوجل</span>
                  <svg>
                    <use href="{{ asset('/assets/images/icons/icons.svg#google') }}"></use>
                  </svg>
                </button>
                <div class="account-exist d-flex align-items-center gap-2">
                  <p class="account-q m-0">هل لديك حساب ؟</p><a class="goto-account" href="{{ route('login') }}">تسجيل الدخول </a>
                </div>
              </form>
          </div>
        </div>
        <div class="log-bg"> <img class="log-bg-img" src="{{asset('/assets/images/log-bg.jpg')}}" alt="Bg"></div>
      </div>
      <footer class="log-footer">
        <ul>
          <li><a href="#">من نحن</a></li>
          <li><a href="#">سياسة الخصوصية</a></li>
        </ul>
      </footer>
    </main>
    <script src="{{asset('/assets/js/mock/mock.js')}}"> </script>
  </body>
</html>
