@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Books Master</div>

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
                                <th>Title</th>
                                <th>Author</th>
                                <th style="width:170px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @if ($data['book']->count() == 0)
                                <tr>
                                    <td align="center" colspan="4">data still empty</td>
                                </tr>
                            @endif
                            @foreach ($data['book'] as $i)
                            <tr>
                                <td align="center">{{ $no++ }}</td>
                                <td>{{ $i->title }}</td>
                                <td>{{ $i->author->name }}</td>
                                <td>
                                    <form action="{{ route('books.destroy', $i->id) }}" id="form-delete{{$i->id}}" method="post">
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
                    {{ $data['book']->links() }}

                </div>

            </div>
        </div>
    </div>
    

    <!-- Modal -->
    <div class="modal fade" id="ActionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Books Form</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            
            <form method="POST" action="{{ route('books.store') }}" id="form-action">
                {{ csrf_field() }}
                <div id="method-div"></div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title" class="col-form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="author" class="col-form-label">Author</label>
                        <select name="author_id" id="author_id" class="form-control">
                            @if ($data['author']->count() == 0)
                                <option value="nothing">Not Available</option>
                            @endif
                            @foreach ($data['author'] as $i)
                                <option value="{{ $i->id }}">{{ $i->name }}</option>
                            @endforeach
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
        document.getElementById('form-action').action = '{{ route('books.store') }}'
        document.getElementById('title').value = ''
        document.getElementById('method-div').innerHTML = '@method('POST')'
    }
    function edit(data) {
        document.getElementById('form-action').action = '{{ url('books') }}' + '/' + data.id
        document.getElementById('title').value = data.title
        document.getElementById('author_id').value = data.author_id
        document.getElementById('method-div').innerHTML = '@method('PUT')'
    }
</script>