@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Authors Master</div>

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
                                <th style="width:30px;" align="center">No</th>
                                <th>name</th>
                                <th style="width:110px;" align="center">total books</th>
                                <th style="width:150px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @if ($data->count() == 0)
                                <tr>
                                    <td align="center" colspan="4">data still empty</td>
                                </tr>
                            @endif
                            @foreach ($data as $i)
                            <tr>
                                <td align="center">{{ $no++ }}</td>
                                <td>{{ $i->name }}</td>
                                <td align="center">{{ $i->book()->count() }}</td>
                                <td>
                                    <form action="{{ route('authors.destroy', $i->id) }}" id="form-delete{{$i->id}}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <a class="btn btn-sm btn-success" onclick="edit({{$i}})" data-toggle="modal" data-target="#ActionModal">Edit</a> |
                                        <button class="btn btn-sm btn-danger" type="submit" form="form-delete{{$i->id}}" onclick="return confirm('Are you sure to delete this data ?')" >Delete</button>
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
            <h5 class="modal-title" id="exampleModalLabel">Authors Form</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            
            <form method="POST" action="{{ route('authors.store') }}" id="form-action">
                {{ csrf_field() }}
                <div id="method-div"></div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
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
        document.getElementById('form-action').action = '{{ route('authors.store') }}'
        document.getElementById('name').value = ''
        document.getElementById('method-div').innerHTML = '@method('POST')'
    }
    function edit(data) {
        document.getElementById('form-action').action = '{{ url('authors') }}' + '/' + data.id
        document.getElementById('name').value = data.name
        document.getElementById('method-div').innerHTML = '@method('PUT')'
    }
</script>