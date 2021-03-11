@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col-12">
        <div id="accordion">
            <div class="card">
                <div class="card-header bg-secondary" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed text-dark" data-toggle="collapse"
                            data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <strong>Add New Category</strong>
                        </button>
                    </h5>
                </div>
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <form method="post" action="{{ action('CategoryController@store') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-12 col-form-label text-md-left">{{ __('Name') }}</label>

                                <div class="col-md-12">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="off" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description"
                                    class="col-md-12 col-form-label text-md-left">{{ __('Description') }}</label>

                                <div class="col-md-12">
                                    <textarea id="description"
                                        class="form-control @error('description') is-invalid @enderror"
                                        name="description">{{ old('description') }}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button class="btn btn-success">Add New Category</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                <h5>All Categories ({{ $categories->count() }})</h5>
            </div>
            <div class="card-bpdy">
                <table class="table table-striped table-sm mb-0">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th width="150">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $key=>$category)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td>
                                <form method="post" action="{{ action('CategoryController@destroy', $category->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <a class="btn btn-sm btn-secondary"
                                        href="{{ action('CategoryController@edit', $category->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
