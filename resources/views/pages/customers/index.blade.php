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
                            <strong>Add New Customer</strong>
                        </button>
                    </h5>
                </div>
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body ">
                        <form method="post" action="{{ action('CustomerController@store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="name"
                                            class=" col-md-12 col-form-label text-md-left">{{ __('Name') }}</label>
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
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="phone_number"
                                            class="col-md-12 col-form-label text-md-left">{{ __('Phone') }}</label>

                                        <div class="col-md-12">
                                            <input id="phone_number" type="text"
                                                class="form-control @error('phone_number') is-invalid @enderror"
                                                name="phone_number" value="{{ old('phone_number') }}" required
                                                autocomplete="off" autofocus>

                                            @error('phone_number')
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
                                                value="{{ old('email') }}" autocomplete="off" autofocus>

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
                                        <label for="address"
                                            class=" col-md-12 col-form-label text-md-left">{{ __('Address') }}</label>

                                        <div class="col-md-12">
                                            <input id="address" type="text"
                                                class="form-control @error('address') is-invalid @enderror"
                                                name="address" value="{{ old('address') }}" required autocomplete="off"
                                                autofocus>

                                            @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="description"
                                            class="col-md-12 col-form-label text-md-left">{{ __('Description') }}</label>

                                        <div class="col-md-12">
                                            <textarea rows="1" id="description"
                                                class="form-control @error('description') is-invalid @enderror"
                                                name="description">{{ old('description') }}</textarea>

                                            @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12 text-right">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="priority" name="priority">
                                        <label class="form-check-label" for="priority">Priority</label>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="favorite"
                                                name="favorite">
                                            <label class="form-check-label" for="favorite">Favorite</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group text-right">
                                        <button class="btn btn-success">Add New Customer</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                <h5>All Customer ({{ $customers->count() }})</h5>
            </div>
            <div class="card-bpdy">
                <table class="table table-striped table-sm mb-0">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Description</th>
                            <th width="150">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $key=>$customer)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->address }}</td>
                            <td>{{ $customer->phone_number }}</td>
                            <td>{{ $customer->description }}</td>
                            <td>
                                <form method="post" action="{{ action('CustomerController@destroy', $customer->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <a class="btn btn-sm btn-secondary"
                                        href="{{ action('CustomerController@edit', $customer->id) }}">
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
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
