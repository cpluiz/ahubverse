@extends('admin.base')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form enctype="multipart/form-data" method="post" target="_self" id="userForm" action="{{route('user_save', $user->id ?? 0)}}" class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Editing User</h3>
                    <!-- /.card-header -->
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if ($errors->any())
                                <div class="alert alert-danger col-12">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            {{csrf_field()}}
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Full Name" value="{{old('name', $user->name)}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="E-mail" value="{{old('email', $user->email)}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" value="">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="confirmpassword">Confirm Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm Password" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <!-- card footer -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Salvar</button>
                        <a href="{{route('users')}}" class="btn btn-default float-right">Cancelar</a>
                    </div>
                    <!-- /.card footer -->
                </form>
                <!-- /.card -->
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script defer>
    $(function () {
        $('#userForm').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    minlength: 6
                },
                confirmpassword: {
                    equalTo: "#password"
                }
            },
            messages: {
                email: {
                    required: "Please enter a email address",
                    email: "Please enter a vaild email address"
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 6 characters long"
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endpush
