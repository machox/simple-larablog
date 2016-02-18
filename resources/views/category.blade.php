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
                    <table class="table table-bordered table-striped" id="categories-table">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($categories))
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{$category->id}}</td>
                                        <td>{{$category->name}}</td>
                                        <td>{{$category->description}}</td>
                                        <td>{{$category->created_at}}</td>
                                        <td>{{$category->updated_at}}</td>
                                        <td>
                                            <button type="button" data-id="{{$category->id}}" class="btn btn-success btn-xs editCategory">Edit</button> 
                                            <button type="button" data-id="{{$category->id}}" class="btn btn-danger btn-xs deleteCategory">Delete</button>
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
    $('#categories-table').DataTable();

    $('#categories-table tbody').on( 'click', '.editCategory', function () {
        window.location.href = '{!! url('/category') !!}/' + $(this).attr('data-id') + '/edit';
        return true;
    } );

    $('#categories-table').on('click', '.deleteCategory', function(e) {        
        if(confirm("Are you sure?"))
        {
            deleteCategory($(this).attr('data-id') );
        }
    });

    function deleteCategory(id) {
        console.log('deleteCategory');
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
            url: "{!! url('/category') !!}/" + id,
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
                window.location.href = '{!! url('/category') !!}';
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('delete category error');
            }
        });
    }
});
</script>
@endsection