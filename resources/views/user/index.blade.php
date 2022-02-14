@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Users Master</div>

                <div class="card-body">

                    {{-- <a href="{{ url('belajar.create') }}"><input class="btn btn-primary btn-sm" type="button" value="Add Book"></a> --}}
                    <button type="button" onclick="add()" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#ActionModal">
                        Add
                    </button>
                    <br><br>
                    
                    @if (session()->has('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session()->get('message') }}
                        </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        {{ implode('', $errors->all(':message')) }}
                    </div>
                    @endif

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width:30px;">No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th style="width:170px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($data as $i)
                            <tr>
                                <td align="center">{{ $no++ }}</td>
                                <td>{{ $i->name }}</td>
                                <td>{{ $i->email }}</td>
                                <td>{{ $i->roles()->where('name', '=', 'admin')->exists() ? 'admin' : 'user'}}</td>
                                <td>
                                    <form action="{{ route('authors.destroy', $i->id) }}" id="form-delete" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <a class="btn btn-sm btn-success" 
                                            onclick="edit({{$i}},'{{ $i->roles()->where('name', '=', 'admin')->exists() ? 'admin' : 'user'}}')" 
                                            data-toggle="modal" data-target="#ActionModal">
                                            Edit
                                        </a> |
                                        <button class="btn btn-sm btn-danger" type="submit" form="form-delete" onclick="return confirm('Are you sure to delete this data ?')" >Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data->links() }}

                </div>

            </div>
        </div>
    </div>
    

    <!-- Modal -->
    <div class="modal fade" id="ActionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Users Form</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            
            <form method="POST" action="{{ route('users.store') }}" id="form-action">
                {{ csrf_field() }}
                <div id="method-div"></div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group" id="input-password">
                        <label for="password" class="col-form-label">Default Password</label>
                        <input type="text" class="form-control" value="password" disabled>
                    </div>
                    <div class="form-group">
                        <label for="role" class="col-form-label">Role</label>
                        <select name="role" id="role" class="form-control">
                            <option value="user">Non Admin</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" form="form-action" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
        </div>
    </div>
</div>
@endsection
<script>
    function add() {
        document.getElementById('form-action').action = '{{ route('users.store') }}'
        document.getElementById('name').value = ''
        document.getElementById('email').value = ''
        document.getElementById('input-password').style.display = "block"
        document.getElementById('role').value = 'user'
        document.getElementById('method-div').innerHTML = '@method('POST')'
    }
    function edit(data, role) {
        document.getElementById('form-action').action = '{{ url('users') }}' + '/' + data.id
        document.getElementById('name').value = data.name
        document.getElementById('input-password').style.display = "none"
        document.getElementById('email').value = data.email
        document.getElementById('role').value = role
        document.getElementById('method-div').innerHTML = '@method('PUT')'
    }
</script>