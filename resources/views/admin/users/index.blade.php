@extends('layouts.admin')

@section('js')
    <!-- confirmation massege script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>

    <script>
        function confirmDelete(categoryId, categoryName) {
            Swal.fire({
                title: 'هل انت متأكد؟',
                text: عندما تحذف المستخدم "${categoryName}". لن تتمكن من استرجاعه,
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
        <h2>المستخدمون</h2>
        <div class="">


        </div>
    </div>
@endsection

<table class="table">
    <thead>
        <tr>
            <th> الصورة </th>
            <th> الأسم </th>
            <th> تاريخ الإنضمام</th>
            <th>الإجراء </th>

        </tr>

    </thead>

    <tbody>
        @foreach ($users as $user)
        @php
            $profile = $profiles->where('user_id', $user->id)->first();
        @endphp
        <tr>
            <td>

            </td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
            <td>
                <form id="deleteForm-{{ $user->id }}" method="POST" action="{{ route('users.destroy', $user->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirmDelete({{ $user->id }}, '{{ $user->name }}')">حذف</button>
                </form>
            </td>
        </tr>
    @endforeach


    </tbody>
    </table>



@endsection
