@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <H3>Upload Files</H3>
                    <form method="POST" action="{{ route('upload') }}" enctype="multipart/form-data"   >
                    @csrf

                    <table class="table" >
                    <tr><th>

                      <div class="form-group row">
                            <label for="file-title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                            <div class="col-md-8">
                                <input id="file-title"  class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" placeholder="Add filename" value="{{ old('title') }}" required>

                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                    </th>
                    <th>

<div class="form-group row">
      <label for="file-path" class="col-md-4 col-form-label text-md-right">{{ __('File') }}</label>

      <div class="col-md-6">
          <input id="file-src" type="file"  class="form-control{{ $errors->has('path') ? ' is-invalid' : '' }}" name="path" value="{{ old('path') }}" required>
          <span class="text-danger" >Max file size is 2MB. </span>
          @if ($errors->has('path'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('path') }}</strong>
              </span>
          @endif
      </div>
  </div>



</th>
<th>
<button type="submit" class="btn btn-primary" >Upload</button>
</th>
                    </tr>
                    </table>
                    </form>
                    <H3>My Files</H3>
<table class="table table-responsive center table-striped" >
<thead>
<tr><th>Title</th><th>Upload Date</th><th>Last Update</th><th>Status</th><th>Size (bytes)</th><th>Action</th></tr>
</thead>
@foreach($files as $file)

<tr  @if(Illuminate\Support\Facades\Storage::lastModified($file->path) != $file->created_at->timestamp || Illuminate\Support\Facades\Storage::exists($file->path) == null) class="table-danger"  @endif ><td>{{$file->title}} </td><td>{{$file->created_at}}</td><td>{{$file->updated_at}}</td>
<td>
@if(Illuminate\Support\Facades\Storage::lastModified($file->path) == $file->created_at->timestamp)
<span class="text-success">OK</span>
 @else
<span class="text-danger">ERROR</span>
 @endif
</td>
<td>{{$file->size}}</td><th>
@if(Illuminate\Support\Facades\Storage::lastModified($file->path) == $file->created_at->timestamp && Illuminate\Support\Facades\Storage::exists($file->path))
<form method="POST" action="{{ route('download') }}">
@csrf
<input type="hidden" value="{{$file->id}}" name="fileid" />
<button class="btn btn-primary" type="submit" >Download</button>
</form>
 @endif

<form method="POST" action="{{ route('remove') }}">
@csrf

<input type="hidden" value="{{$file->id}}" name="fileid" />
<button class="btn btn-danger" type="submit" >Delete</button>
</form>

</th></tr>
@endforeach
</table>
<!-- <H3>Trash</H3>

<table class="table table-responsive center table-striped table-dark" >
<tr><th>Title</th><th>Upload Date</th><th>Last Update</th><th>Size (bytes)</th><th>Action</th></tr>

@foreach($trash as $file)
<tr><td>{{$file->title}} </td><td>{{$file->created_at}}</td><td>{{$file->updated_at}}</td><td>{{$file->size}}</td><th>
<form method="POST" action="{{ route('restore') }}">
@csrf
<input type="hidden" value="{{$file->id}}" name="fileid" />
<button class="btn btn-default" type="submit" >Restore</button>
</form>
</th></tr>
@endforeach
</table> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
