@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                <form role="form" method="POST" action="/2fa">
@csrf
<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
<input id="2fa" type="text" class="form-control" name="2fa" placeholder="Enter the code you received here." required autofocus>
@if ($errors->has('2fa'))
<span class="help-block">
<strong>{{ $errors->first('2fa') }}</strong>
</span>
@endif
</div>
<div class="form-group">
<button class="btn btn-primary" type="submit">Send</button>
</div>
</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
