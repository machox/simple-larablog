@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <!-- Box -->
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
          <div class="box">
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{ $url_action }}">
                <input type="hidden" name="_method" value="{{ $method }}">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="box-body">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="@if(isset($category->name)){{$category->name}}@endif">
                </div>
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea class="form-control" name="description" rows="5" placeholder="Enter Description">@if(isset($category->description) && $category->description){{$category->description}}@endif</textarea>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection