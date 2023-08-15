@extends('Dashboard.master')

@section('title')
    Profile
@endsection
@section('Page-title')
    Profile
@endsection
@section('content')

    <div class="container">
        <div class="card card-custom">
            <!--begin::Header-->
            <div class="card-header py-3">
                <div class="card-title align-items-start flex-column">
                    <h3 class="card-label font-weight-bolder text-dark">Change Password</h3>
                    <span class="text-muted font-weight-bold font-size-sm mt-1">Change your account password</span>
                </div>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-primary mr-2" onclick="submitForm()">Save Changes</button>
                    <button type="reset" class="btn btn-secondary" onclick="resetForm()">Cancel</button>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Form-->
            <form method="post" action="{{ route("editProfile") }}" enctype="multipart/form-data" id="passwordForm">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <!--begin::Alert-->
                    <!--end::Alert-->
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Name</label>
                        <div class="col-lg-9 col-xl-6">
                            <input class="form-control form-control-lg form-control-solid mb-2 {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                   type="text"
                                   name="name" id="name" value="{{ old('name', $auth->name) }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Current Password</label>
                        <div class="col-lg-9 col-xl-6">
                            <input name="oldPassword" type="password" id="oldPassword"
                                   class="form-control form-control-lg form-control-solid mb-2" value=""
                                   placeholder="Current Password" required>
                            <a href="" class="text-sm font-weight-bold">Forgot Password ?</a>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">New Password</label>
                        <div class="col-lg-9 col-xl-6">
                            <input id="password" type="password"
                                   class="form-control form-control-lg form-control-solid"
                                   name="password"
                                   autocomplete="new-password"   placeholder="New Password" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Verify Password</label>
                        <div class="col-lg-9 col-xl-6">
                            <input id="password_confirmation" type="password"
                                   class="form-control form-control-lg form-control-solid"
                                   name="password_confirmation" autocomplete="new-password"   placeholder="Confirm Password"required>
                        </div>

                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
    </div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        function submitForm() {
            var form = document.getElementById('passwordForm');
            var oldPassword = form.elements.namedItem('oldPassword').value;
            var newPassword = form.elements.namedItem('password').value;
            var confirmPassword = form.elements.namedItem('password_confirmation').value;

            axios.put('/company/editProfile', {
                oldPassword: oldPassword,
                password: newPassword,
                password_confirmation: confirmPassword
            }, {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(function (response) {
                    toastr.success(response.data.message);
                    form.reset();
                })
                .catch(function (error) {
                    if (error.response && error.response.data && error.response.data.message) {
                        toastr.warning(error.response.data.message);
                    } else {
                        toastr.error('An error occurred while updating the password.');
                    }
                });
        }

        function resetForm() {
            var form = document.getElementById('passwordForm');
            form.reset();
        }
    </script>
@endsection
