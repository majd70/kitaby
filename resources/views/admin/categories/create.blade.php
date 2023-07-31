@extends('layouts.admin')

@section('title')
     إنشاء تصنيف جديد
@endsection



@section('content')

    <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
        @csrf


        <!--read validate error-->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $message)
                        <li> {{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="form-group">
            <label for="">{{__('اسم التصنيف')}}</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}">
            @error('name')
                <!--read validate error in spesific field-->
                <p class="invalid-feedback">{{ $message }} </p>
            @enderror
        </div>





        <div class="form-group">
            <label for="">الوصف</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description">{{old('description')}}</textarea>

            @error('description')
                <!--read validate error in spesific field-->
                <p class="invalid-feedback">{{ $message }} </p>
            @enderror
        </div>


        <div class="form-group">
            <label for="">الصورة</label>
            <input type="file" class="form-control" name="image">

            @error('image')
                <!--read validate error in spesific field-->
                <p class="text-danger">{{ $message }} </p>
            @enderror

        </div>



        </div>



        <div class="form-group">
            <button type="submit" class="btn btn-primary">حفظ</button>
        </div>




    </form>

@endsection
