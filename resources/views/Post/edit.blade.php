@extends('Books.layouts')

@section('js')
<script>
    function updateImageName(input) {
        var fileName = input.files[0].name;
        var imagesBox = document.getElementById('imagesBox');
        imagesBox.innerHTML = '<img src="/uploads/' + fileName + '" alt="New Post Image">';
    }
</script>

@endsection

@section('content')
    <div class="posts-section edit-section">

        <div class="mr-modal-container" id="modalContainer">
            <form class="mr-modal-box" method="POST" action="{{ route('posts.update', $post->id) }}"   enctype="multipart/form-data"  >
                @method('PUT')
                @csrf
                <div id="mrAddProduct">
                    <div class="mr-modal-header">
                        <button class="close-btn" type="button" id="closeModal">
                            <svg class="mr-modal-prev-svg">
                                <use href="../assets/images/icons/icons.svg#close"></use>
                            </svg>
                        </button>
                        <h2 class="myModal-title">تعديل المنشور </h2>
                    </div>
                    <div class="product-details-box">
                        <div class="write-post-modal d-flex">
                            <div class="post-writer-img-box">
                                <a class="d-flex justify-content-between align-items-center"
                                    href="/profile/{{ Auth::user()->id }}">
                                    <img class="post-writer-img" src="/profile-images/{{ $profile->image }}"
                                        alt="post writer img">
                                </a>
                            </div>
                            <a class="post-writer-name" href="/profile/{{ Auth::user()->id }}">
                                {{ Auth::user()->name }}
                            </a>
                            {{-- ////////// --}}
                        </div>
                        <div class="post-content">
                            <textarea class="modal-input textarea" name="content" cols="30" rows="10" placeholder="بماذا تفكر">{{ old('content', $postContent) }}</textarea>

                            <div id="imagesBox">

                            </div>
                        </div>
                        <div class="push-post-box">
                            <div class="post-photo-box d-flex justify-content-center align-items-center start-post">
                                <label class="post-img-label" for="uploadImg">
                                    <input class="choose-photograph-input" id="uploadImg" type="file"
                                        accept="image/*" name="image" onchange="readURL(this)">
                                    <img src="../assets/images/postPhoto.png" >
                                    <span>صورة</span>
                                </label>
                            </div>
                            <button class="mr-modal-btn" type="submit" id="postBtn">تعديل</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
