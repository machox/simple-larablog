@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            <!-- Box -->
            <div class="box">
                <div class="box-body">
                    <table class="table table-bordered table-striped" id="posts-table">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($posts))
                                @foreach ($posts as $post)
                                    <tr>
                                        <td>{{$post->id}}</td>
                                        <td>{{$post->title}}</td>
                                        <td>@if (isset($post->category->name)) {{$post->category->name}} @endif</td>
                                        <td>{{$post->status}}</td>
                                        <td>{{$post->created_at}}</td>
                                        <td>{{$post->updated_at}}</td>
                                        <td>
                                            <button type="button" data-id="{{$post->id}}" class="btn btn-primary btn-xs viewPost">View</button> 
                                            <button type="button" data-id="{{$post->id}}" class="btn btn-success btn-xs editPost">Edit</button> 
                                            <button type="button" data-id="{{$post->id}}" class="btn btn-danger btn-xs deletePost">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
<script>
$( document ).ready(function() {
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
    $('#posts-table').DataTable();

    $('#posts-table tbody').on( 'click', '.viewPost', function () {
        window.location.href = '{!! url("/home/show/") !!}/' + $(this).attr('data-id');
        return true;
    } );

    $('#posts-table tbody').on( 'click', '.editPost', function () {
        window.location.href = '{!! url('/post') !!}/' + $(this).attr('data-id') + '/edit';
        return true;
    } );

    $('#posts-table').on('click', '.deletePost', function(e) {  
        e.preventDefault();               
        if(confirm("Are you sure?"))
        {
            deletePost($(this).attr('data-id') );
        }
    });

    function deletePost(id) {
        console.log('deletePost');
        $(document).ajaxStart(function () {
            $("input").prop('disabled', true);
            $("select").prop('disabled', true);
            $("button").prop('disabled', true);
        });
        $(document).ajaxStop(function () {
            $("input").prop('disabled', false);
            $("select").prop('disabled', false);
            $("button").prop('disabled', false);
        });
        $.ajax({
            type: 'DELETE',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType: "json",
            url: '{!! url('/post') !!}/' + id,
            data: {  
               _token: "{!! csrf_token() !!}",
               id: id
            },
            success: function(data, textStatus, jqXHR){
                if(data.status.error == true) {
                    alert(data.status.message);
                } else {
                    alert(data.status.message);
                }
                window.location.href = '{!! url('/post') !!}';
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('delete post error');
            }
        });
    }
});
</script>
@endsection