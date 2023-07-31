@extends('Books.layouts')

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <script>
        /*
                                  $(document).ready(function() {
                                    $('#editButton').click(function() {
                                        var postId = $(this).data('post-id');
                                        var form = $('#modalContainer2').find('form');
                                        var actionUrl = '/post/' + postId;
                                        var csrfToken = $('meta[name="csrf-token"]').attr('content');

                                        form.attr('action', actionUrl);
                                        form.find('input[name="_method"]').val('PUT');
                                        form.append('<input type="hidden" name="_token" value="' + csrfToken + '">');

                                        // Open the modal
                                        $('#modalContainer2').fadeIn();
                                    });

                                    $('#closeModal').click(function() {
                                        // Close the modal
                                        $('#modalContainer2').fadeOut();
                                    });
                                });

                                */

        /*
            $(document).ready(function() {
                $('.dropdown-item-1').click(function() {

                    console.log('cliking button');

                    var postId = $(this).data('post-id');
                    var form = $('#modalContainer2').find('form');
                    var actionUrl = '/post/' + postId;

                    console.log(actionUrl);

                    var csrfToken = $('meta[name="csrf-token"]').attr('content');



                    form.attr('action', actionUrl);
                    form.find('input[name="_method"]').val('PUT');
                    form.append('<input type="hidden" name="_token" value="' + csrfToken + '">');

                    // Open the modal
                    $('#modalContainer2').fadeIn();
                    console.log('oppenning modal');
                });

                // Event delegation for the close button
                $(document).on('click', '#closeModal', function() {
                    // Close the modal
                    $('#modalContainer2').fadeOut();
                });
            });
            */
    </script>





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
        /*
                                                                    $(document).on('click', '.delete-comment-btn', function(event) {
                                                                        event.preventDefault();

                                                                        console.log('form submited');

                                                                        var form = $(this).closest('.delete-comment-form');
                                                                        var url = form.attr('action');

                                                                         console.log(url);

                                                                        $.ajax({
                                                                            url: url,
                                                                            type: 'DELETE',
                                                                            data: form.serialize(),
                                                                            dataType: 'json',
                                                                            success: function(response) {
                                                                                // Handle success response
                                                                               // console.log(response.message);

                                                                                // Optionally, you can remove the deleted comment from the DOM
                                                                                form.closest('.comment-body').remove();
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
                                                                    */

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
        /*
                                                                        $(document).on('submit', '#commentForm', function(event) {
                                                                          event.preventDefault();
                                                                          console.log('Form submitted!');

                                                                          var formData = $(this).serialize();
                                                                          console.log(formData);

                                                                          var postId = $(this).data('post-id');

                                                                          $.ajax({
                                                                            url: '{{ route('comments.store', ['post' => ':post']) }}'.replace(':post', postId),
                                                                            method: 'POST',
                                                                            data: formData,
                                                                            dataType: 'json',
                                                                            success: function(response) {
                                                                              var comment = JSON.stringify(response);
                                                                              console.log(comment);

                                                                             // comment = JSON.parse(comment);
                                                                             //console.log(comment);

                                                                // Create HTML markup for the new comment
                                                                 // Create the HTML for the new comment
                                                                 var commentHtml = `
          <div class="comment-body">
            <div class="posted-comment d-flex">
              <div class="comment-writer-img">
                <a class="d-flex justify-content-between align-items-center" href="/profile/${comment.user_id}">
                  <img src="/profile-images/${comment.user.profile_image}" alt="comment writer">
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
                      <button class="dropdown-item" type="button">تعديل</button>
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
              <button class="reaction-box like-reaction-btn">
                <p class="reaction-type">أعجبني</p>
              </button>
            </div>
          </div>
        `;

                                                                      // Append the new comment to the comments-box element
                                                                      $('.comments-box').append(commentHtml);



                                                                              // Clear the comment form
                                                                              $('#commentForm')[0].reset();

                                                                              // Show a success message or perform any other actions
                                                                              alert('Comment posted successfully!');
                                                                            },
                                                                            error: function(jqXHR, textStatus, errorThrown) {
                                                                              console.error('AJAX request failed: ' + textStatus, errorThrown);
                                                                              // Handle the error or show an error message
                                                                            }
                                                                          });
                                                                        });

                                                                        */


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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<script>
    /*
                              $(document).ready(function() {
                                $('#editButton').click(function() {
                                    var postId = $(this).data('post-id');
                                    var form = $('#modalContainer2').find('form');
                                    var actionUrl = '/post/' + postId;
                                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                                    form.attr('action', actionUrl);
                                    form.find('input[name="_method"]').val('PUT');
                                    form.append('<input type="hidden" name="_token" value="' + csrfToken + '">');

                                    // Open the modal
                                    $('#modalContainer2').fadeIn();
                                });

                                $('#closeModal').click(function() {
                                    // Close the modal
                                    $('#modalContainer2').fadeOut();
                                });
                            });

                            */

    /*
        $(document).ready(function() {
            $('.dropdown-item-1').click(function() {

                console.log('cliking button');

                var postId = $(this).data('post-id');
                var form = $('#modalContainer2').find('form');
                var actionUrl = '/post/' + postId;

                console.log(actionUrl);

                var csrfToken = $('meta[name="csrf-token"]').attr('content');



                form.attr('action', actionUrl);
                form.find('input[name="_method"]').val('PUT');
                form.append('<input type="hidden" name="_token" value="' + csrfToken + '">');

                // Open the modal
                $('#modalContainer2').fadeIn();
                console.log('oppenning modal');
            });

            // Event delegation for the close button
            $(document).on('click', '#closeModal', function() {
                // Close the modal
                $('#modalContainer2').fadeOut();
            });
        });
        */
</script>





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
    /*
                                                                $(document).on('click', '.delete-comment-btn', function(event) {
                                                                    event.preventDefault();

                                                                    console.log('form submited');

                                                                    var form = $(this).closest('.delete-comment-form');
                                                                    var url = form.attr('action');

                                                                     console.log(url);

                                                                    $.ajax({
                                                                        url: url,
                                                                        type: 'DELETE',
                                                                        data: form.serialize(),
                                                                        dataType: 'json',
                                                                        success: function(response) {
                                                                            // Handle success response
                                                                           // console.log(response.message);

                                                                            // Optionally, you can remove the deleted comment from the DOM
                                                                            form.closest('.comment-body').remove();
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
                                                                */

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
    /*
                                                                    $(document).on('submit', '#commentForm', function(event) {
                                                                      event.preventDefault();
                                                                      console.log('Form submitted!');

                                                                      var formData = $(this).serialize();
                                                                      console.log(formData);

                                                                      var postId = $(this).data('post-id');

                                                                      $.ajax({
                                                                        url: '{{ route('comments.store', ['post' => ':post']) }}'.replace(':post', postId),
                                                                        method: 'POST',
                                                                        data: formData,
                                                                        dataType: 'json',
                                                                        success: function(response) {
                                                                          var comment = JSON.stringify(response);
                                                                          console.log(comment);

                                                                         // comment = JSON.parse(comment);
                                                                         //console.log(comment);

                                                            // Create HTML markup for the new comment
                                                             // Create the HTML for the new comment
                                                             var commentHtml = `
      <div class="comment-body">
        <div class="posted-comment d-flex">
          <div class="comment-writer-img">
            <a class="d-flex justify-content-between align-items-center" href="/profile/${comment.user_id}">
              <img src="/profile-images/${comment.user.profile_image}" alt="comment writer">
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
                  <button class="dropdown-item" type="button">تعديل</button>
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
          <button class="reaction-box like-reaction-btn">
            <p class="reaction-type">أعجبني</p>
          </button>
        </div>
      </div>
    `;

                                                                  // Append the new comment to the comments-box element
                                                                  $('.comments-box').append(commentHtml);



                                                                          // Clear the comment form
                                                                          $('#commentForm')[0].reset();

                                                                          // Show a success message or perform any other actions
                                                                          alert('Comment posted successfully!');
                                                                        },
                                                                        error: function(jqXHR, textStatus, errorThrown) {
                                                                          console.error('AJAX request failed: ' + textStatus, errorThrown);
                                                                          // Handle the error or show an error message
                                                                        }
                                                                      });
                                                                    });

                                                                    */


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
                                        <div class="post-date"> <span class="day">13</span><span
                                                class="month">أذار</span>-<span class="clock">8:56</span><span
                                                class="am-pm">م</span></div>
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
                                                    <a class="dropdown-item" href="{{ route('posts.edit', ['post' => $post->id, 'group' => $group->id]) }}">تعديل</a>

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
                                                    <form action="{{ route('groups.users.report', ['groupId' => $group->id, 'userId' => $post->user_id]) }}" method="POST">
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
                                        <img src="/profile-images/{{ Auth::user()->profile->image }}" alt="comment writer">
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

        </div>
    </div>
</section>






@endsection
