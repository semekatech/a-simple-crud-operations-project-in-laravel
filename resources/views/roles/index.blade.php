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
            <h1 class="h3 mb-0 text-gray-800">Roles List</h1>
        </div>

        <div class="row mt-2">
            <div class="col-12">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" style="background:dodgerblue" data-toggle="modal" data-target="#addRoleModal">
                    Add Role
                </button>
                <br/><br/>
                <!-- Role Modals -->
                @foreach ($roles as $role)
                    <div class="modal" id="editRoleModal{{ $role->id }}" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Role: {{ $role->name }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="editRoleForm" data-role-id="{{ $role->id }}">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="id" value="{{ $role->id }}">
                                        <div class="form-group">
                                            <label for="editRoleName{{ $role->id }}">Role Name</label>
                                            <input type="text" class="form-control" id="editRoleName{{ $role->id }}" name="name" value="{{ $role->name }}">
                                        </div>

                                        <div class="form-group">
                                            <label>Permissions</label>
                                                @php
                                                $rolePermissions = $role->permissions->pluck('permission_id')->toArray();
                                                @endphp

                                                @foreach ($permissions as $permission)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="{{ $permission->id }}" name="permissions[]" {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label">{{ $permission->name }}</label>
                                                    </div>
                                                @endforeach

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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                <a href="#" class="edit-link" data-toggle="modal" data-target="#editRoleModal{{ $role->id }}">Edit</a>
                                <a href="#" class="delete-link" data-toggle="modal" data-target="#deleteRoleModal{{ $role->id }}">Delete</a>
                                </td>
                            </tr>

                            <div class="modal" id="deleteRoleModal{{ $role->id }}" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete Role: {{ $role->name }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this role?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" style="background:dodgerblue" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger" style="background:red" onclick="deleteRole({{ $role->id }})">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                        @endforeach
                        @if (!$roles)
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
                    <h5 class="modal-title">Add Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form id="addRoleForm" action="{{ route('save-role') }}" method="POST">
                         @csrf
                        <div class="form-group">
                            <label for="roleName">Role Name</label>
                            <input type="text" class="form-control" id="roleName" name="name">
                        </div>
                        <div class="form-group">
                            <label>Permissions</label>
                            @foreach ($permissions as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $permission->id }}" name="permissions[]">
                                    <label class="form-check-label">{{ $permission->name }}</label>
                                </div>
                            @endforeach
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
