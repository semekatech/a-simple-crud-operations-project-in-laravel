@extends('layouts.master')
@section('content')
<style>
    .delete-link {
        color: red; 
        cursor: pointer;
        margin-right: 5px;
        transition: color 0.3s ease;
    }
    .edit-link {
        color: #007bff;
        cursor: pointer;
        margin-right: 5px;
        transition: color 0.3s ease;
    }
    .edit-link:hover, .delete-link:hover {
        color: #0056b3; 
    }
</style>

<div class="container-fluid">
    <div class="container">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Staff List</h1>
        </div>

        <div class="row mt-2">
            <div class="col-12">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" style="background:dodgerblue" data-toggle="modal" data-target="#addRoleModal">
                    Add Staff
                </button>
                <br/><br/>
                <!-- Role Modals -->
                @foreach ($users as $user)
                    <div class="modal" id="editRoleModal{{ $user->id }}" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Role: {{ $user->name }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="editRoleForm" data-role-id="{{ $user->id }}">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <div class="form-group">
                                            <label for="editRoleName{{ $user->id }}">Role Name</label>
                                            <input type="text" class="form-control" id="editRoleName{{ $user->id }}" name="name" value="{{ $user->name }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary" style="background:dodgerblue">Update Role</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach

                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role_name }}</td>
                            </tr>

                        @endforeach
                        @if (!$users)
                            <tr>
                                <td colspan="3">No roles found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Add Role Modal -->
<div class="modal" id="addRoleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Staff</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form id="addRoleForm" action="{{ route('save-user') }}" method="POST">
                         @csrf
                        <div class="form-group">
                            <label for="roleName">Name</label>
                            <input type="text" class="form-control" id="roleName" name="name">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" id="roleName" name="email">
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select name="role_id" class="form-control" style="" >
                                <option value="">--Select--</option>
                                @foreach ($roles as $role)
                                <td>{{ $user->id }}</td>
                                <option value="{{ $role->id }}" >{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" style="background:dodgerblue">Save Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
   
    $('.editRoleForm').submit(function (e) {
        e.preventDefault();

        var form = $(this);
        var roleId = 3;

        $.ajax({
            type: 'PUT',
            url: '{{ url('update-role') }}/' + roleId,
            data: form.serialize(),
            success: function (response) {
                // Hide the modal
                setTimeout(function () {
                $('#editRoleModal' + roleId).modal('hide');
            }, 1000);

            setTimeout(function () {
                location.reload();
            }, 2000);
             
         toastr.success('Role Updated successfully', 'Success');
            },
            error: function (error) {
            }
        });
    });


    function deleteRole(roleId) {
        // AJAX request to delete the role
        $.ajax({
            type: 'DELETE',
            url: '{{ url('delete-role') }}/' + roleId,
            data: {
            _token: '{{ csrf_token() }}', 
        },
            success: function (response) {
                toastr.success('Role Updated successfully', 'Success');
                location.reload();
            },
            error: function (error) {
            }
        });
    }
</script>

@endsection
