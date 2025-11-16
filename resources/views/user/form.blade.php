<div class="row">
    <div class="col-lg-12 order-lg-1">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">User Info</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ $route }}">
                    @csrf
                    @if ($type == 'EDIT')
                        @method('PUT')
                    @endif

                    <div class="row">
                        <x-ui.input
                            class="input"
                            name="name"
                            label="Name"
                            type="text"
                            placeholder="Name"
                            :value="(isset($user) && $user->name)? $user->name : old('name')"
                            col="col-md-6"
                            required
                            :disabled="false"
                        />
                        <x-ui.input
                            class="input"
                            name="phone_number"
                            label="Phone Number"
                            type="text"
                            placeholder="+60123456789"
                            :value="(isset($user) && $user->phone_number)? $user->phone_number : old('phone_number')"
                            col="col-md-6"
                            required
                            :disabled="false"
                        />
                    </div>

                    <div class="row">
                        <x-ui.input
                            name="email"
                            label="Email address"
                            type="email"
                            placeholder="example@example.com"
                            :value="(isset($user) && $user->email)? $user->email : old('email')"
                            col="col-md-6"
                            required
                            :disabled="false"
                        />
                        <x-ui.input
                            class="input"
                            name="password"
                            label="Password"
                            type="password"
                            placeholder=""
                            :value="(isset($user) && $user->password)? $user->password : ''"
                            col="col-md-6"
                            required
                            :disabled="false"
                        />
                    </div>

                    <div class="row">
                        <x-ui.select
                            name="status"
                            label="Status"
                            :options="false"
                            :selected="(isset($user) && $user->status)? $user->status : ''"
                            :nullable="false"
                            col="col-md-6"
                            required
                            :select2="true"
                            :disabled="false"
                        />

                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <div class="p-1"></div>
                        <a href="{{ route('user.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>