@extends('layouts.admin')

@section('js')
    <!-- confirmation massege script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>

    <script>
        function confirmDelete(categoryId, categoryName) {
            Swal.fire({
                title: 'هل انت متأكد?',
                text: `عندما تحذف التصنيف "${categoryName}". لن تتمكن من استرجاعه`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'نعم, قم بالحذف!',
                cancelButtonText: 'لا، شكرًا'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-' + categoryId).submit();
                }
            });
            return false; // Prevents the default form submission
        }
    </script>

    <!-- success massege script-->
    <script>
        // Delay in milliseconds (3 seconds = 3000 milliseconds)
        var delay = 4000;

        // Get the success message element
        var successMessage = document.getElementById('success-message');

        // Hide the success message after the delay
        setTimeout(function() {
            successMessage.style.display = 'none';
        }, delay);
    </script>
@endsection

@section('content')

    <x-alert success="{{ session('success') }}" />


@section('title')
    <div class="d-flex justify-content-between">
        <h2>التصنيفات </h2>
        <div class="">

            <a class="btn btn-s btn-outline-primary" href="{{ route('categories.create') }}"> إنشاء</a>

        </div>
    </div>
@endsection

<table class="table">
    <thead>
        <tr>
            <th> الصورة </th>
            <th> الأسم </th>


            <th> الوصف </th>
            <th> تاريخ الأنشاء </th>

        </tr>

    </thead>

    <tbody>

        @foreach ($categories->sortByDesc('updated_at') as $category)
            <tr>



                <td> <img src="{{ $category->image_url }}" width="90" height="90" alt=""> </td>
                <td>{{ $category->name }} </td>

                <td>{{ $category->description }} </td>
                <td>{{ $category->created_at }} </td>

                <td><a href="{{ route('categories.edit', $category->id) }}" class="btn btn-small btn-dark">تعديل</a></td>

                <td>
                    <form id="deleteForm-{{ $category->id }}" method="POST"
                        action="{{ route('categories.destroy', $category->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirmDelete({{ $category->id }}, '{{ $category->name }}')">حذف</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>

</table>


@endsection
