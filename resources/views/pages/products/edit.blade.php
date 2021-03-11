@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col-12">
        <div id="accordion">
            <div class="card">
                <div class="card-header bg-secondary" id="headingOne">
                    <h5 class="mb-0">
                        <a class="btn btn-secondary" href="{{ action('ProductController@index') }}">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a>
                        <button class="btn btn-link text-dark" data-toggle="collapse" data-target="#collapseOne"
                            aria-expanded="true" aria-controls="collapseOne">
                            <strong>
                                Edit: {{ $product->name }}
                            </strong>
                        </button>
                    </h5>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body ">
                        <form method="post" action="{{ action('ProductController@store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="name">{{ __('Name') }}</label>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ $product->name }}" required autocomplete="off" autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="description">{{ __('Description') }}</label>

                                        <textarea rows="1" id="description"
                                            class="form-control @error('description') is-invalid @enderror"
                                            name="description">{{ $product->description }}</textarea>

                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="brand">Brand</label>
                                        <select name="brand" id="brand" class="form-control select2 select2-default"
                                            data-placeholder="Select Brand...">
                                            @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ $product->brand_id == $brand->id? "selected":"" }}>
                                                {{ $brand->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <select name="category" id="category"
                                            class="form-control select2 select2-default"
                                            data-placeholder="Select category...">
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $product->category_id == $category->id? "selected":"" }}>
                                                {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="unit">Unit</label>
                                        <select name="unit" id="unit" class="form-control select2 select2-default"
                                            data-placeholder="Select unit...">
                                            @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}"
                                                {{ $product->unit_id == $unit->id? "selected":"" }}>{{ $unit->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group text-right">
                                        <button class="btn btn-success">Update Product</button>
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