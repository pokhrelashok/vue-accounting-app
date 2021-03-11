@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col-12">
        <div id="accordion">
            <div class="card">
                <div class="card-header bg-secondary" id="headingOne">
                    <h5 class="mb-0">
                        <a class="btn btn-secondary" href="{{ action('UserController@index') }}">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a>
                        <button class="btn btn-link text-dark" data-toggle="collapse" data-target="#collapseOne"
                            aria-expanded="true" aria-controls="collapseOne">
                            <strong>
                                Edit: {{ $user->name }}
                            </strong>
                        </button>
                    </h5>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <form method="post" action="{{ action('UserController@update',$user->id) }}">
                            <div class="row">
                                @csrf
                                @method('put')
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="name"
                                            class=" col-md-12 col-form-label text-md-left">{{ __('Name') }}</label>
                                        <div class="col-md-12">
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ $user->name }}" required autocomplete="off" autofocus>

                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="email"
                                            class="col-md-12 col-form-label text-md-left">{{ __('Email') }}</label>

                                        <div class="col-md-12">
                                            <input id="email" type="text"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ $user->email }}" autocomplete="off" autofocus>

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="password"
                                            class="col-md-12 col-form-label text-md-left">{{ __('Password') }}</label>

                                        <div class="col-md-12">
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" autocomplete="off" autofocus>

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1"
                                            class="col-md-12 col-form-label text-md-left">Select Company</label>
                                        <div class="col-md-12">
                                            <select name="company" class="form-control" id="exampleFormControlSelect1">
                                                <option value="">Select Company</option>
                                                @foreach ($companies as $company)
                                                <option {{$company->id == $user->company_id ? 'selected' : ''}}
                                                    value="{{$company->id}}">{{$company->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('company')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="form-group text-right">
                                        <button class="btn btn-success">Update user</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
