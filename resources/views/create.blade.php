@extends('layouts/main_layout')
@section('content')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-8">
                <div class="card p-5">
                    
                    <!-- logo -->
                    <div class="text-center p-3">
                        <img src="assets/images/logo.png" alt="Notes logo">
                    </div>

                    <!-- form -->
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-12">
                            <form action="/createSubmit" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="text_username" class="form-label">Username</label>
                                    <input type="text" class="form-control bg-dark text-info" name="text_username" value="{{old('text_username')}}">
                                {{-- msg errors type 1--}}
                                  @error('text_username')
                                  <div class="text-danger">{{$message}}</div>
                                  @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="text_password" class="form-label">Password</label>
                                    <input type="password" class="form-control bg-dark text-info" name="text_password" value="{{old('text_password')}}">
                                {{-- msg errors type 1--}}
                                  @error('text_password')
                                  <div class="text-danger">{{$message}}</div>
                                  @enderror
                                </div>
                                <div class="mb-3">
                                        <label for="text_password_confirm" class="form-label">Password Confirm</label>
                                        <input type="password" class="form-control bg-dark text-info" name="text_password_confirm" value="{{old('text_password_confirm')}}">
                                    {{-- msg errors type 1--}}
                                    @error('text_password_confirm')
                                    <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>


                                
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-secondary w-100">CREATE ACCOUNT</button>
                                </div>
                                
                            </form>

                                <div class="mb-3">
                                    <a href="{{route('home')}}" class="btn btn-secondary w-100">RETURN LOGIN</a>
                                </div>
                            {{-- invalid login --}}
                            @if(session('loginError'))
                            <div class="alert alert-danger text-center">
                                {{session('loginError')}}
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- copy -->
                    <div class="text-center text-secondary mt-3">
                        <small>&copy; <?= date('Y') ?> Notes</small>
                    </div>
                    {{-- msg errors type 2--}}
                    @if ($errors->any())
                        <div class=" alert alert-danger mt-3">
                            <ul class="m-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection