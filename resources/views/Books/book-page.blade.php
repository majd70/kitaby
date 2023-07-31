@extends('Books.layouts')

@section('css')
    <style>
        .image-container {
            width: 550px;
            height: 250px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
@endsection


@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



    <script>
        //finshesd ajax request for like
        $(document).ready(function() {
            $('.like-reaction-btn').click(function(event) {
                event.preventDefault(); // Prevent the form from submitting normally

                var form = $(this).closest('form');
                var url = form.attr('action');

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: form.serialize(), // Serialize the form data
                    // ...

                    // ...

                    success: function(response) {
                            // Handle the success response here
                            console.log('Like request succeeded');
                            console.log(response);

                            // Update the like count on the page
                            var likeCount = response.likes_count;
                            var postId = response.post_id;
                            var likeCountElement = $('.like-count-' + postId);
                            likeCountElement.text(likeCount);

                            // Toggle the "liked" class on the like button
                            $('#like-btn-' + postId).toggleClass('liked');
                        }


                        // ...


                        // ...
                        ,
                    error: function(xhr, status, error) {
                        // Handle the error response here
                        console.log('Like request failed');
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>



    <script>
        $('.delete-comment-btn').click(function(event) {
            event.preventDefault();

            console.log('form submitted');

            var deleteBtn = $(this);
            var form = deleteBtn.closest('.delete-comment-form');
            var url = form.attr('action');

            console.log(url);

            $.ajax({
                url: url,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Handle success response
                    console.log(response.message);

                    // Remove the deleted comment from the DOM
                    var commentBody = deleteBtn.closest('.comment-body');
                    commentBody.remove();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed: ' + status, error);
                    if (xhr.responseText) {
                        console.log(xhr.responseText);
                    } else {
                        console.log('Empty response received');
                    }
                }
            });
        });
    </script>


    <script>
        //finshed ajax request for creating comment
        $(document).on('submit', '#commentForm', function(event) {
            event.preventDefault();

            var formData = $(this).serialize();
            console.log(formData);

            var postId = $(this).data('post-id');

            $.ajax({
                url: '{{ route('comments.store', ['post' => ':post']) }}'.replace(':post', postId),
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    var comment = response.comment;

                    // Create the HTML for the new comment
                    var commentHtml = `
          <div class="comment-body">
            <div class="posted-comment d-flex">
              <div class="comment-writer-img">
                <a class="d-flex justify-content-between align-items-center" href="/profile/${comment.user_id}">
                  <img src="/profile-images/${comment.user.profile.image}" alt="comment writer">
                </a>
              </div>
              <div class="posted-comment-text-box d-flex flex-column">
                <a class="comment-writer-name" href="/profile/${comment.user_id}">${comment.user.name}</a>
                <p class="comment-text">${comment.content}</p>
              </div>
              <ul class="post-action-menu">
                <li class="nav-item dropdown bootstrap-things">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <p class="post-dot"></p>
                    <p class="post-dot"></p>
                    <p class="post-dot"></p>
                  </a>
                  <ul class="dropdown-menu">
                    <li>

                    </li>
                    <form action="/comments/${comment.post_id}/${comment.id}" method="POST">
                      @csrf
                      @method('DELETE')
                      <li>
                        <button class="dropdown-item" type="submit">حذف</button>
                      </li>
                    </form>
                  </ul>
                </li>
              </ul>
            </div>
            <div class="comment-reactions-box">

            </div>
          </div>
        `;

                    $('#comments-box-' + postId).append(commentHtml);

                    // Clear the comment form
                    $('#commentForm')[0].reset();

                    // Show a success message or perform any other actions
                    //alert('Comment posted successfully!');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX request failed: ' + textStatus, errorThrown);
                    // Handle the error or show an error message
                }
            });
        });
    </script>
@endsection

@section('book-bar')
    <div class="book-pages-bar"> <a class="book-bar-links active" href="#">حوار</a>
        <a class="book-bar-links" href="/book-member/{{ $group->id }}">الأعضاء</a>
        <a class="book-bar-links" href="/book-about/{{ $group->id }}">عن الكتاب</a>
    </div>
@endsection

@section('content')
    <section class="posts-section">
        <div class="container">
            <div class="small-container">
                {{-- --}}
                @if (Auth::check() && Auth::user()->groups->contains($group))
                    <div class="create-post-box post-box">
                        <div class="write-post-layout d-grid">
                            <div class="post-writer-img-box">
                                <a class="d-flex justify-content-between align-items-center"
                                    href="/profile/{{ $userId }}">
                                    <img class="post-writer-img" src="/profile-images/{{ $profile->image }}"
                                        alt="post writer img">
                                </a>
                            </div>
                            <div class="write-post-text-area start-post" id="openMrModal"><span>أكتب منشور ...</span></div>
                        </div>
                        <div class="post-photo-box d-flex justify-content-center align-items-center start-post"><img
                                src="../assets/images/postPhoto.png" alt="Post Photo"><span>صورة</span></div>
                    </div>
                @else
                    <div class="create-post-box post-box">
                        <form action="/group/{{ $group->id }}/join" method="POST">
                            @csrf
                            انضمام للمجموعة لكتابة منشور

                            <button type="submit" class="btn btn-primary">انضمام</button>
                        </form>
                    </div>
                @endif
                {{-- --}}
                <div class="mr-modal-container" id="modalContainer">
                    <form class="mr-modal-box" method="POST" action="/post/{{ $group->id }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div id="mrAddProduct">
                            <div class="mr-modal-header">
                                <button class="close-btn" type="button" id="closeModal">
                                    <svg class="mr-modal-prev-svg">
                                        <use href="../assets/images/icons/icons.svg#close"></use>
                                    </svg>
                                </button>
                                <h2 class="myModal-title">أكتب منشور</h2>
                            </div>
                            <div class="product-details-box">
                                <div class="write-post-modal d-flex">
                                    <div class="post-writer-img-box"><a
                                            class="d-flex justify-content-between align-items-center"
                                            href="/profile/{{ $userId }}">


                                            <img class="post-writer-img"
                                                src="/profile-images/{{ Auth::user()->profile->image }}"
                                                alt="post writer img">



                                        </a></div><a class="post-writer-name"
                                        href="/profile/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a>
                                    {{-- ////////// --}}
                                </div>
                                <div class="post-content">
                                    <textarea class="modal-input textarea" name="content" cols="30" rows="10" placeholder=" بماذا تفكر"></textarea>
                                    <div id="imagesBox"></div>
                                </div>
                                <div class="push-post-box">
                                    <div class="post-photo-box d-flex justify-content-center align-items-center start-post">
                                        <label class="post-img-label" for="uploadImg">
                                            <input class="choose-photograph-input" id="uploadImg" type="file"
                                                accept="image/*" name="image" onchange="readURL(this)">
                                            <img src="../assets/images/postPhoto.png" alt="Post Photo">
                                            <span>صورة</span>
                                        </label>
                                    </div>

                                    <button class="mr-modal-btn" type="submit" id="postBtn">أنشر</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>







                @foreach ($posts->sortByDesc('created_at') as $post)
                    <div class="post-box">
                        @foreach ($users as $user)
                            {{-- ////// --}}
                            @if ($post->user_id == $user->id)
                                <div class="post-info d-flex justify-content-between align-items-center">
                                    <div class="post-writer-info d-flex">
                                        <div class="post-writer-img-box"><a
                                                class="d-flex justify-content-between align-items-center"
                                                href="/profile/{{ $user->id }}">
                                                @foreach ($profiles as $profile)
                                                    @if ($profile->user_id == $user->id)
                                                        <img class="post-writer-img"
                                                            src="/profile-images/{{ $profile->image }}"
                                                            alt="post writer img">
                                                    @endif
                                                @endforeach
                                            </a></div>

                                        <div class="post-writer-name-and-date d-flex flex-column"><a
                                                class="post-writer-name"
                                                href="/profile/{{ $user->id }}">{{ $user->name }}</a>
                                            <div class="post-date">
                                                <span class="day">{{ $post->created_at->format('d') }}</span>
                                                <span class="month">{{ $post->created_at->format('M') }}</span>-
                                                <span class="clock">{{ $post->created_at->format('H:i') }}</span>
                                                <span class="am-pm">{{ $post->created_at->format('A') }}</span>
                                            </div>

                                        </div>
                                    </div>

                                    <ul class="post-action-menu">
                                        <li class="nav-item dropdown bootstrap-things"><a class="nav-link dropdown-toggle"
                                                href="#" role="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <p class="post-dot"></p>
                                                <p class="post-dot"></p>
                                                <p class="post-dot"></p>
                                            </a>
                                            @if (Auth::user()->id == $post->user_id)
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('posts.edit', ['post' => $post->id, 'group' => $group->id]) }}">تعديل</a>

                                                        {{--   عدلها لما اضغط عليها تنقلي ل فورم التعديل  --}}
                                                    </li>
                                                    <form action="/post/{{ $post->id }}" method="POSt">
                                                        @csrf
                                                        @method('DELETE')
                                                        <li>
                                                            <button class="dropdown-item" type="submit">حذف</button>
                                                        </li>
                                                    </form>
                                                </ul>
                                            @else
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <form
                                                            action="{{ route('groups.users.report', ['groupId' => $group->id, 'userId' => $post->user_id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button class="dropdown-item" type="submit">إبلاغ</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            @endif
                                        </li>
                                    </ul>

                                </div>
                            @endif
                        @endforeach

                        <div class="post-body">
                            <div class="post-text-box">
                                <p class="post-text">{{ $post->content }}</p>
                            </div>
                        </div>

                        @if ($post->image)
                            <div class="image-container">
                                <img class="post-image" src="{{ asset('uploads/' . $post->image) }}" alt="Post Image"
                                    style="max-width: 100%; max-height: 100%;">
                            </div>
                        @endif

                        <form id="like-form" action="/post/{{ $post->id }}/like" method="POST">
                            <div class="post-reactions-box">
                                <div class="reaction-container d-flex align-items-center">
                                    @csrf
                                    <button
                                        class="reaction-box like-reaction-btn @if ($post->likes()->where('user_id', auth()->user()->id)->exists()) liked @endif"
                                        id="like-btn-{{ $post->id }}">
                                        <div class="like-reaction"></div>
                                        <p class="reaction-type">أعجبني</p>
                                        <span class="like-count like-count-{{ $post->id }}">
                                            {{ $post->likes->count() }}
                                        </span>
                                    </button>
                                    <button class="reaction-box">
                                        <div class="comment-reaction"></div>
                                        <p class="reaction-type">تعليق</p>
                                    </button>


                                </div>
                            </div>
                        </form>

                        <div class="comments-box" id="comments-box-{{ $post->id }}">

                            <div class="write-comment d-grid">
                                <div class="comment-writer-img">
                                    <a class="d-flex justify-content-between align-items-center"
                                        href="/profile/{{ $userId }}">
                                        <img src="/profile-images/{{ Auth::user()->profile->image }}"
                                            alt="comment writer">
                                    </a>
                                </div>
                                @if (Auth::user()->groups->contains($group))
                                    <form id="commentForm" class="write-comment-inputs-box"
                                        action="/comments/{{ $post->id }}" method="POST" onsubmit="submitForm()"
                                        data-post-id="{{ $post->id }}">
                                        @csrf
                                        <input type="text" class="input-comment-text" name="content"
                                            placeholder="أكتب تعليق ..." autofocus>
                                        <label class="input-file-label" for="commentFile">
                                            <svg>
                                                <use href="../assets/images/icons/icons.svg#Camera"></use>
                                            </svg>
                                            <input class="input-comment-file" id="commentFile" type="file"
                                                name="file">
                                        </label>
                                        <input type="submit" style="display:none;">
                                    </form>
                                @else
                                    <form class="write-comment-inputs-box" action="#">
                                        @csrf
                                        <input type="text" class="input-comment-text" name="content"
                                            placeholder="أكتب تعليق ..." autofocus>
                                        <label class="input-file-label" for="commentFile">
                                            <svg>
                                                <use href="../assets/images/icons/icons.svg#Camera"></use>
                                            </svg>
                                            <input class="input-comment-file" id="commentFile" type="file"
                                                name="file">
                                        </label>
                                        <input type="button" style="display:none;">
                                    </form>
                                @endif
                            </div>
                            @foreach ($post->comments as $comment)
                                <div class="comment-body">
                                    <div class="posted-comment d-flex">
                                        <div class="comment-writer-img"> <a
                                                class="d-flex justify-content-between align-items-center"
                                                href="/profile/{{ $comment->user_id }}">
                                                @foreach ($profiles as $profile)
                                                    @if ($profile->user_id == $comment->user_id)
                                                        <img src="/profile-images/{{ $profile->image }}"
                                                            alt="comment writer">
                                                    @endif
                                                @endforeach
                                            </a></div>
                                        <div class="posted-comment-text-box d-flex flex-column"> <a
                                                class="comment-writer-name"
                                                href="/profile/{{ $comment->user_id }}">{{ $comment->user->name }}</a>
                                            <p class="comment-text">{{ $comment->content }}</p>
                                        </div>
                                        <ul class="post-action-menu">
                                            <li class="nav-item dropdown bootstrap-things"><a
                                                    class="nav-link dropdown-toggle" href="#" role="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <p class="post-dot"></p>
                                                    <p class="post-dot"></p>
                                                    <p class="post-dot"></p>
                                                </a>
                                                @if (Auth::user()->id == $comment->user_id)
                                                    <ul class="dropdown-menu">
                                                        <li>

                                                        </li>
                                                        <form class="delete-comment-form"
                                                            action="/comments/{{ $post->id }}/{{ $comment->id }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <li>
                                                                <button class="dropdown-item delete-comment-btn"
                                                                    type="submit">حذف</button>
                                                            </li>
                                                        </form>
                                                    </ul>
                                                @else
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <button class="dropdown-item" type="button">إبلاغ</button>
                                                        </li>
                                                    </ul>
                                                @endif
                                            </li>
                                        </ul>

                                    </div>
                                    <div class="comment-reactions-box">

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
