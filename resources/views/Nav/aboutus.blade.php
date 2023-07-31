<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="/assets/images/favIcon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-DOXMLfHhQkvFFp+rWTZwVlPVqdIhpDVYT9csOnHSgWQWPX0v5MCGtjCJbY6ERspU" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Start NavBar-->
    <!-- End NavBar-->
    <!-- Start Book Cover Section -->
    <!-- End Book Cover Section -->
    <title>الصفحة الرئيسة</title>
  </head>
  <body>
    <div class="home-page-layout">
        <div class="nav-bar-component">

            <div class="container">
              <nav class="navbar navbar-expand-lg">
                <div class="container-fluid"><a class="navbar-brand" href="/"><img class="nav-log" src="/assets/images/Logo.png" alt="Logo"></a>
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="nav-line"></span><span class="nav-line"></span><span class="nav-line"></span></button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 main-list">
                      <li class="nav-item"><a class="nav-link" href="/">الرئيسة</a></li>
                      <li class="nav-item"><a class="nav-link" href="{{route('categories2.index')}}">التصنيفات</a></li>
                      <li class="nav-item"><a class="nav-link" href="{{route('aboutus')}}">من نحن</a></li>
                      <li class="nav-item"><a class="nav-link" href="../../contactUs.html">تواصل معنا</a></li>
                    </ul>
                  </div>
                </div>
              </nav>
              <ul class="navbar-nav mb-2 mb-lg-0 navbar-absolute">
                <li class="nav-item dropdown bootstrap-things profile-icon-box">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                    @if (auth()->check() && $profile && $profile->image)
                                <img class="profile-icon" src="/profile-images/{{ $profile->image }}"
                                    alt="profile icon">
                            @endif
                    </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item log-link" href="{{ route('profile') }}"><span>الملف الشخصي </span>
                        <svg>
                          <use href="{{asset('assets/images/icons/icons.svg#profile')}}"></use>
                        </svg></a></li>
                        @if(Auth::check())
                            <a class="dropdown-item log-link" href="{{ route('logout') }}">
                                <span>تسجيل الخروج</span>
                                <svg>
                                    <use href="/assets/images/icons/icons.svg#logout"></use>
                                </svg>
                            </a>
                        </li>
                    @else
                        <li>
                            <a class="dropdown-item log-link" href="{{ route('login') }}">
                                <span>تسجيل الدخول</span>
                                <svg>
                                    <use href="/assets/images/icons/icons.svg#login"></use>
                                </svg>
                            </a>
                        </li>
                    @endif
                    </li>
              </ul>
              <x-notificationmenu/>
              </ul>
            </div>
          </div>
          <div class="page-background-section"> <img src="../../assets/images/pagesBg.png" alt="pagesBg">
            <h1 class="bg-section-title">من نحن</h1>
          </div>
      <main class="main-padding">
        <div class="container">
              <section class="about-us-section d-grid">
                <div class="about-info-box">
                  <h2 class="about-title">ما هو موقع كتابي؟</h2>
                  <p class="about-text">كتابي: موقع إعلامي لعشاق الكتب إذا كنت قارئًا نهمًا يستمتع بمناقشة الكتب والروايات والأشعار مع الآخرين ، فستحب كتابي. كتابي هو موقع تواصل اجتماعي مصمم خصيصًا لعشاق الكتب الذين يرغبون في التواصل مع الآخرين الذين يشاركونهم شغفهم في الأدب.</p>
                </div>
                <div class="about-img-box"> <img class="about-img" src="../assets/images/log-bg.jpg" alt="About Img"></div>
              </section>
              <section class="about-us-section d-grid">
                <div class="about-img-box"> <img class="about-img" src="../assets/images/heroBG.png" alt="About Img"></div>
                <div class="about-info-box">
                  <h2 class="about-title">كيف يعمل كتابي؟</h2>
                  <p class="about-text">يسمح كتابي للمستخدمين بإنشاء مجموعات مخصصة لأنواع أو مواضيع معينة ، حيث يمكن للأعضاء مناقشة وتبادل أفكارهم حول الكتب والمؤلفين والموضوعات الأدبية المفضلة لديهم. يمكن للأعضاء أيضًا إنشاء منشورات والمشاركة في مناقشات مع مستخدمين آخرين لديهم اهتمامات مماثلة.</p>
                </div>
              </section>
              <section class="about-us-section d-grid">
                <div class="about-info-box">
                  <h2 class="about-title">مميزات كتابي</h2>
                  <p class="about-text">من الميزات الفريدة في كتابي أنه يوفر منصة للكتاب لمشاركة أعمالهم الخاصة مع الأعضاء الآخرين. يمكن للشعراء والمؤلفين الطموحين استخدام كتابي لمشاركة أعمالهم وتلقي التعليقات من الأعضاء الآخرين والتواصل مع الكتاب الآخرين في هذا النوع.</p>
                </div>
                <div class="about-img-box"> <img class="about-img" src="../assets/images/heroBG.jpg" alt="About Img"></div>
              </section>
              <section class="about-us-section d-grid">
                <div class="about-img-box"> <img class="about-img" src="../assets/images/discussion1.jpg" alt="About Img"></div>
                <div class="about-info-box">
                  <h2 class="about-title">ربط نوادي الكتب</h2>
                  <p class="about-text">يوفر كتابي أيضًا منصة لنوادي الكتاب لربط أنشطتها وتنسيقها. يمكن للأعضاء استخدام كتابي لجدولةالاجتماعات ومناقشة قوائم القراءة ومشاركة المراجعات والتوصيات مع بعضهم البعض.</p>
                </div>
              </section>
              <section class="about-us-section d-grid">
                <div class="about-info-box">
                  <h2 class="about-title">استكشاف عالم سهل الاستخدام في كتابي</h2>
                  <p class="about-text">موقع الويب سهل الاستخدام ، ويسهل تصميمه البسيط على المستخدمين التنقل والعثور على ما يبحثون عنه. مع مجتمعها المتنامي من محبي الكتب والكتاب ، تقدم كتابي فرصة عظيمة للأفراد للتفاعل مع الآخرين الذين يشاركونهم اهتماماتهم وتوسيع آفاقهم الأدبية.</p>
                </div>
                <div class="about-img-box"> <img class="about-img" src="../assets/images/adab.jpg" alt="About Img"></div>
              </section>
        </div>
      </main>
    </div>
    <div class="footer-box">
      <div class="container">
        <footer class="row row-cols-1 row-cols-sm-2 row-cols-md-5 py-5 border-top">
          <div class="col mb-3"><a class="d-flex align-items-center mb-3 link-dark text-decoration-none" href="/"><img class="footer-logo" src="/assets/images/Logo.png" alt="Logo"></a></div>
          <div class="col mb-3"></div>
          <div class="col mb-3">
            <h5>الرئيسة</h5>
            <ul class="nav flex-column">
              <li class="nav-item mb-2"><a class="nav-link p-0" href="../../about.html">من نحن</a></li>
              <li class="nav-item mb-2"><a class="nav-link p-0" href="../../contactUs.html">تواصل معنا</a></li>
              <li class="nav-item mb-2"><a class="nav-link p-0" href="#">الأسئلة الشائعة</a></li>
            </ul>
          </div>
          <div class="col mb-3">
            <h5>كتابي</h5>
            <ul class="nav flex-column">
              <li class="nav-item mb-2"><a class="nav-link p-0" href="#">سياسة الخصوصية</a></li>
              <li class="nav-item mb-2"><a class="nav-link p-0" href="#">سياسة الاستخدام</a></li>
              <li class="nav-item mb-2"><a class="nav-link p-0" href="#">الشروط و الأحكام</a></li>
            </ul>
          </div>
          <div class="col mb-3">
            <h5>الأقسام</h5>
            <ul class="nav flex-column">
              <li class="nav-item mb-2"><a class="nav-link p-0" href="/categories.html">التصنيفات</a></li>
              <li class="nav-item mb-2"><a class="nav-link p-0" href="#">كتبي</a></li>
              <li class="nav-item mb-2"><a class="nav-link p-0" href="#">الكتب المنضم لها</a></li>
            </ul>
          </div>
        </footer>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
  </body>
</html>
