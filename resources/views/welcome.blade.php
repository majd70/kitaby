<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="/assets/images/favIcon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-DOXMLfHhQkvFFp+rWTZwVlPVqdIhpDVYT9csOnHSgWQWPX0v5MCGtjCJbY6ERspU" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Start NavBar-->
    <!-- End NavBar-->
    <!-- Start Book Cover Section -->
    <!-- End Book Cover Section -->
    <title>الصفحة الرئيسة</title>
</head>

<body>
    <div class="home-page-layout">
        <!-- Start main section -->
        <div class="nav-bar-component">

            <div class="container">
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid"><a class="navbar-brand" href="/"><img class="nav-log"
                                src="/assets/images/Logo.png" alt="Logo"></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation"><span class="nav-line"></span><span
                                class="nav-line"></span><span class="nav-line"></span></button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0 main-list">
                                <li class="nav-item"><a class="nav-link" href="/">الرئيسة</a></li>
                                <li class="nav-item"><a class="nav-link"
                                        href="{{ route('categories2.index') }}">التصنيفات</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('aboutus') }}">من نحن</a></li>
                                <li class="nav-item"><a class="nav-link" href="../../contactUs.html">تواصل معنا</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <ul class="navbar-nav mb-2 mb-lg-0 navbar-absolute">
                    <li class="nav-item dropdown bootstrap-things profile-icon-box">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">

                            @if (auth()->check() && $profile && $profile->image)
                                <img class="profile-icon" src="/profile-images/{{ $profile->image }}"
                                    alt="profile icon">
                            @endif

                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item log-link" href="{{ route('profile') }}"><span>الملف الشخصي
                                    </span>
                                    <svg>
                                        <use href="{{ asset('assets/images/icons/icons.svg#profile') }}"></use>
                                    </svg></a></li>
                            @if (Auth::check())
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

                @if(auth()->check())
                <x-notificationmenu/>
                 @endif


                </ul>
            </div>
        </div>
        <main>
            <section class="hero-section">
                <div class="hero-text-container">
                    <h1 class="hero-title">ابدأ الأن بمناقشة الكتب المهُتم بها</h1>
                    <h2 class="hero-subtitle">أسلوب جديد لمناقشة الكتب بالعربية</h2>
                    @auth
                        <!-- User is logged in, hide the button -->
                    @else
                        <!-- User is not logged in, show the button -->
                        <div class="hero-btn-box"><a href="{{ route('login') }}">ابدأ الأن</a></div>
                    @endauth
                </div>
                <div class="overlay"></div>
                <video class="hero-bg" loop muted autoplay>
                    <source src="../assets/videos/heroVideo.mp4" type="video/mp4">
                </video>
            </section>
            <section class="modern-categories-section">
                <div class="container">
                    <div class="section-title">
                        <h2>التصنيفات و أحدث الكتب</h2>
                    </div>
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            @foreach ($categories as $category)
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#{{ $category->name }}"
                                    type="button" role="tab" aria-controls="{{ $category->name }}"
                                    aria-selected="true">
                                    {{ $category->name }}
                                </button>
                            @endforeach
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        @foreach ($categories as $category)
                            <div class="tab-pane fade" id="{{ $category->name }}" role="tabpanel"
                                aria-labelledby="{{ $category->name }}-tab" tabindex="0">
                                <div class="panel-grid">
                                    @foreach ($category->groups->sortByDesc('created_at')->take(5) as $group)
                                        <div class="col">


                                            <a class="card customized-card" href="/book-page/{{$group->id}}">
                                                <div class="card-img-box">
                                                    <img class="card-img-top" src="/images/{{ $group->image }}"
                                                        alt="{{ $group->name }}">
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $group->name }}</h5>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        <div class="hero-btn-box"><a href="{{ route('categories2.index') }}">اكتشف المزيد</a></div>
                    </div>
                </div>
            </section>

        </main>
    </div>
    <div class="footer-box">
        <div class="container">
            <footer class="row row-cols-1 row-cols-sm-2 row-cols-md-5 py-5 border-top">
                <div class="col mb-3"><a class="d-flex align-items-center mb-3 link-dark text-decoration-none"
                        href="/"><img class="footer-logo" src="/assets/images/Logo.png" alt="Logo"></a>
                </div>
                <div class="col mb-3"></div>
                <div class="col mb-3">
                    <h5>الرئيسة</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a class="nav-link p-0" href="../../about.html">من نحن</a></li>
                        <li class="nav-item mb-2"><a class="nav-link p-0" href="../../contactUs.html">تواصل معنا</a>
                        </li>
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
    <script src="../assets/js/home.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>



</body>

</html>
