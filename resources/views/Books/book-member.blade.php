@extends('Books.layouts')

@section('book-bar')
    <div class="book-pages-bar"> <a class="book-bar-links" href="/book-page/{{ $group->id }}">حوار</a>
        <a class="book-bar-links active" href="">الأعضاء</a>
        <a class="book-bar-links" href="/book-about/{{ $group->id }}">عن الكتاب</a>
    </div>
@endsection


@section('css')
    <style>
        .member-box {
            background-color: #f5f5f5;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .red-box {
            background-color: #ff8080;
            color: #fff;
            border-color: #ff3333;
        }



        .red-box span {
            color: #fff;
        }

        /* Optional: Hover effect */
        /* .member-box:hover {
            transform: scale(1.05);
            transition: transform 0.2s ease-in-out;
        } */
    </style>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>
@endsection

@section('content')

    <section class="members-section">
        @if (session('alert'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'انتباه!',
                        text: "{{ session('alert') }}",
                        icon: 'warning',
                        confirmButtonText: 'OK',
                        customClass: {
                            container: 'my-swal-container',
                            title: 'my-swal-title',
                            text: 'my-swal-text',
                            confirmButton: 'my-swal-confirm-button',
                        }
                    });
                });
            </script>
        @endif
        <div class="small-container">
            <div class="members-content">
                <div class="members-subtitle-box d-flex align-items-center justify-content-start">
                    <h2 class="members-subtitle m-0">الأعضاء</h2>
                    <p class="members-title-dot m-0"> </p>
                    <p class="members-number m-0">{{ $number_of_users }}</p>
                </div>
                <div class="border-member">
                    <div class="member-box">
                        <div class="member-img-box"> <a href="/profile/{{ Auth::user()->id }}"><img
                                    src="/profile-images/{{ $profile->image }}" alt="member image"></a></div>
                        <div class="member-info"> <a class="member-link" href="/profile/{{ Auth::user()->id }}">
                                <p>{{ Auth::user()->name }}</p>
                            </a></div>
                        <ul class="post-action-menu">
                            <li class="nav-item dropdown bootstrap-things"><a class="nav-link dropdown-toggle"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <p class="post-dot"></p>
                                    <p class="post-dot"></p>
                                    <p class="post-dot"></p>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        @if (Auth::user()->groups->contains($group))
                                            <form action="/group/{{ $group->id }}/leave" method="POST">
                                                @csrf
                                                <button class="dropdown-item" type="submit">غادر المجموعة</button>
                                            </form>
                                            @if ($group->group_user()->where('user_id', Auth::user()->id)->first()->group_user_role === 'admin')
                                                <form action="/group/{{ $group->id }}/leave-admin" method="POST">
                                                    @csrf
                                                    <button class="dropdown-item" type="submit">ترك دور الإدارة</button>
                                                </form>
                                            @endif
                                        @else
                                            <form action="/group/{{ $group->id }}/join" method="POST">
                                                @csrf
                                                <button class="dropdown-item" type="submit">انضم للمجموعة</button>
                                            </form>
                                        @endif

                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="members-subtitle-box d-flex align-items-center justify-content-start mt-3">
                        <h2 class="members-subtitle m-0">المشرفون</h2>
                        <p class="members-title-dot m-0"> </p>
                        <p class="members-number m-0">{{ count($admins_name) }}</p>
                    </div>
                    @foreach ($admins_name as $admin_name)
                        <div class="member-box">
                            <div class="member-img-box"> <a href="/profile/{{ $admin_name->id }}">
                                    @foreach ($profiles as $profile)
                                        @if ($profile->user_id == $admin_name->id)
                                            <img src="/profile-images/{{ $profile->image }}" alt="member image">
                                        @endif
                                    @endforeach
                                </a></div>

                            <div class="member-info"> <a class="member-link" href="/profile/{{ $admin_name->id }}">
                                    <p>{{ $admin_name->name }}</p>
                                </a></div>
                            <div class="visit-member-profile"> <a href="/profile/{{ $admin_name->id }}"><img
                                        src="../assets/images/seeProfile.png" alt="see profile"></a></div>
                        </div>
                    @endforeach

                </div>
                @foreach ($members_name as $member)
                    <div class="member-box">
                        <div class="member-img-box">
                            <a href="/profile/{{ $member->id }}">
                                @foreach ($profiles as $profile)
                                    @if ($profile->user_id == $member->id)
                                        <img src="/profile-images/{{ $profile->image }}" alt="member image">
                                    @endif
                                @endforeach
                            </a>
                        </div>
                        <div class="member-info">
                            <a class="member-link" href="/profile/{{ $member->id }}">
                                <p>{{ $member->name }}</p>
                            </a>
                        </div>
                        {{-- <div class="visit-member-profile">
                            <a href="/profile/{{ $member->id }}">
                                <img src="../assets/images/seeProfile.png" alt="see profile">
                            </a>
                        </div>
                        @if ($isGroupAdmin && $member->id !== $currentUserId)
                            <a href="{{ route('groups.members.delete', ['groupId' => $group->id, 'memberId' => $member->id]) }}"
                                onclick="event.preventDefault(); document.getElementById('delete-form-{{ $member->id }}').submit();">Delete</a>

                            <form id="delete-form-{{ $member->id }}"
                                action="{{ route('groups.members.delete', ['groupId' => $group->id, 'memberId' => $member->id]) }}"
                                method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>


                            <a href="{{ route('groups.members.make-admin', ['groupId' => $group->id, 'memberId' => $member->id]) }}"
                                onclick="event.preventDefault(); document.getElementById('make-admin-form-{{ $member->id }}').submit();">
                                جعله مشرفاً
                            </a>

                            <form id="make-admin-form-{{ $member->id }}"
                                action="{{ route('groups.members.make-admin', ['groupId' => $group->id, 'memberId' => $member->id]) }}"
                                method="POST" style="display: none;">
                                @csrf
                            </form> --}}
                            {{-- ========================== --}}

                            <ul class="post-action-menu">
                                <li class="nav-item dropdown bootstrap-things"><a class="nav-link dropdown-toggle"
                                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <p class="post-dot"></p>
                                        <p class="post-dot"></p>
                                        <p class="post-dot"></p>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>

                                            <div class="hataf-image-menu">
                                                <a class="dropdown-item" href="/profile/{{ $member->id }}">
                                                    {{-- <img src="../assets/images/seeProfile.png" alt="see profile"> --}}
                                                    الملف الشخصي
                                                </a>
                                            </div>
                                        </li>
                                        <li class="hataf-li">
                                            @if ($isGroupAdmin && $member->id !== $currentUserId)
                                            <a class="dropdown-item" href="{{ route('groups.members.make-admin', ['groupId' => $group->id, 'memberId' => $member->id]) }}"
                                                onclick="event.preventDefault(); document.getElementById('make-admin-form-{{ $member->id }}').submit();">
                                                جعله مشرفاً
                                            </a>

                                            <form id="make-admin-form-{{ $member->id }}"
                                                action="{{ route('groups.members.make-admin', ['groupId' => $group->id, 'memberId' => $member->id]) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                            <div class="dropdown-item {{ $member['report_count'] > 3 ? 'red-box' : '' }}">
                                                <span><img class="red-falg" src="../assets/images/red-flag.png" /> البلاغات: {{ $member['report_count'] }}</span>
                                            </div>
                                            <a class="dropdown-item" href="{{ route('groups.members.delete', ['groupId' => $group->id, 'memberId' => $member->id]) }}"
                                                onclick="event.preventDefault(); document.getElementById('delete-form-{{ $member->id }}').submit();">طرد</a>
                                                <form id="delete-form-{{ $member->id }}"
                                                    action="{{ route('groups.members.delete', ['groupId' => $group->id, 'memberId' => $member->id]) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                        @endif
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            {{-- ========================== --}}
                            <!-- Display the number of reports -->

                            <!-- Display the number of reports -->
                            {{-- <div class="member-box {{ $member['report_count'] > 3 ? 'red-box' : '' }}">
                                <span>عدد البلاغات: {{ $member['report_count'] }}</span>
                            </div>
                        @endif --}}
                    </div>
                @endforeach

            </div>
        </div>
    </section>
@endsection
