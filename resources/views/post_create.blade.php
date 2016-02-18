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
                  <label for="title">Title</label>
                  <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title" value="@if(isset($post->title)){{$post->title}}@endif">
                </div>
                <div class="form-group">
                  <label for="category">Category</label>
                  <select name="category" class="form-control">
                    @if ($categories)
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if(isset($post->category_id) && $post->category_id == $category->id)selected="selected"@endif>{{ $category->name }}</option>
                        @endforeach
                    @endif
                  </select>
                </div>
                <div class="form-group">
                  <label for="content">Content</label>
                  <textarea class="form-control" name="content" rows="5" placeholder="Enter Content">@if(isset($post->content) && $post->content){{$post->content}}@endif</textarea>
                </div>
                <div class="form-group">
                  <label for="status">Status</label>
                  <select name="status" class="form-control">
                    <option @if(isset($post->status) && $post->status == 'published')selected="selected"@endif value="published">Published</option>
                    <option @if(isset($post->status) && $post->status == 'pending')selected="selected"@endif value="pending">Pending</option>
                  </select>
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