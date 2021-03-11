@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-12">
            <div id="accordion">
                <div class="card">
                    <div class="card-header bg-secondary" id="headingOne">
                        <h5 class="mb-0">
                            <a class="btn btn-secondary" href="{{ action('CategoryController@index') }}">
                                <i class="fas fa-arrow-circle-left"></i>
                            </a>
                            <button class="btn btn-link text-dark" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <strong>
                                    Edit: {{ $category->name }}
                                </strong>
                            </button>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <form method="post" action="{{ action('CategoryController@update', $category->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <label for="name" class="col-md-12 col-form-label text-md-left">{{ __('Name') }}</label>

                                    <div class="col-md-12">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $category->name }}" required autocomplete="off" autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
	                                        <strong>{{ $message }}</strong>
	                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="description" class="col-md-12 col-form-label text-md-left">{{ __('Description') }}</label>

                                    <div class="col-md-12">
                                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description">{{ $category->description }}</textarea>

                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
	                                        <strong>{{ $message }}</strong>
	                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group text-right">
                                    <button class="btn btn-primary">Update Category</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
