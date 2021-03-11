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
                            <strong>Add New User</strong>
                        </button>
                    </h5>
                </div>
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body ">
                        <form method="post" action="{{ action('UserController@store') }}">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="user" id="" value="{{ Auth::id() }}">
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
                                        <label for="password"
                                            class="col-md-12 col-form-label text-md-left">{{ __('Password') }}</label>

                                        <div class="col-md-12">
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" value="{{ old('password') }}" autocomplete="off"
                                                autofocus>

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
                                                @foreach ($companies as $company)
                                                <option value="{{$company->id}}">{{$company->name}}</option>
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
                                        <button class="btn btn-success">Add New user</button>
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
                <h5>All users ({{ $users->count() }})</h5>
            </div>
            <div class="card-bpdy">
                <table class="table table-striped table-sm mb-0">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Email</th>
                            <th width="150">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key=>$user)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->company->name ?? '---' }}</td>
                            <td>{{ $user->email ?? '---' }}</td>
                            <td>
                                <form method="post" action="{{ action('UserController@destroy', $user->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <a class="btn btn-sm btn-secondary"
                                        href="{{ action('UserController@edit', $user->id) }}">
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
                {{-- {{ $users->links() }} --}}
            </div>
        </div>
    </div>
</div>
@endsection
