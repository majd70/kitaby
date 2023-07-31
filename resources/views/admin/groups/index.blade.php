@extends('layouts.admin')

@section('js')
    <!-- confirmation massege script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>

    <script>
        function confirmDelete(categoryId, categoryName) {
            Swal.fire({
                title: 'هل انت متأكد؟',
                text: `عندما تحذف المجموعة "${categoryName}". لن تتمكن من استرجاعها`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'نعم، قم بالحذف!',
                cancelButtonText: 'لا، شكرًا'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-' + categoryId).submit();
                }
            });
            return false; // Prevents the default form submission
        }
    </script>

    <!-- success message script -->
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
        <h2>المجموعات</h2>
        <div class="">


        </div>
    </div>
@endsection

<table class="table">
    <thead>
        <tr>
            <th> الصورة </th>
            <th> الأسم </th>
            <th> التصنيف </th>
            <th> عدد الأعضاء </th>
            <th> تاريخ الأنشاء </th>
            <th> الإجراء </th>

        </tr>

    </thead>

    <tbody>

        @foreach ($groups as $group)
            <tr>



                <td>
                    <a href="/book-page/{{$group->id}}">
                    <img src="/images/{{ $group->image }}" width="90" height="90" alt="">
                  </a> </td>
                <td>{{ $group->name }} </td>

                <td>{{ $group->category->name }} </td>

                <td>{{ $group->users->count() }} </td>

                <td>{{ $group->created_at->format('Y-m-d H:i:s') }}</td>



                <td>
                    <form id="deleteForm-{{ $group->id }}" method="POST"
                        action="{{ route('groups.destroy', $group->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirmDelete({{ $group->id }}, '{{ $group->name }}')">حذف</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>

</table>


@endsection
