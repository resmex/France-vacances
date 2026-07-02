@extends('layouts.front')

@section('title', 'My Profile — France Vacances')

@section('page')
@include('partials.navbar')

<!-- Page Hero -->
<section class="tt-page-hero tt-page-hero-sm" style="background-image:url('{{ asset('images/about.jpg') }}');">
	<div class="container">
		<h1 class="tt-page-title">Account Settings</h1>
		<p class="tt-page-subtitle">Update your personal details and change your password.</p>
	</div>
</section>

<section class="tt-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">

				@if(session('success'))
				<div class="alert alert-success border-0 rounded-3 mb-4">
					<i class="fas fa-check-circle me-2"></i>{{ session('success') }}
				</div>
				@endif

				@if($errors->any())
				<div class="alert alert-danger border-0 rounded-3 mb-4">
					<ul class="mb-0 ps-3">
						@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
				@endif

				<!-- Profile Details -->
				<div class="tt-sidebar-card mb-4">
					<h5 class="fw-bold mb-4">
						<i class="fas fa-user-edit me-2" style="color:var(--tt-accent);"></i>Personal Details
					</h5>
					<form action="{{ route('account.profile.update') }}" method="POST" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<div class="mb-4">
							<label class="form-label fw-semibold">Profile Photo</label>
							<div class="d-flex align-items-center gap-3">
								<div class="tt-profile-photo-preview">
									@if($user->profile_photo)
									<img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
									@else
									<i class="fas fa-user"></i>
									@endif
								</div>
								<div class="flex-grow-1">
									<input type="file" name="profile_photo" id="profile_photo"
										   class="tt-input @error('profile_photo') is-invalid @enderror" accept=".jpg,.jpeg,.png">
									<div class="form-text text-muted">JPG or PNG, max 2MB.</div>
									@error('profile_photo')
									<div class="invalid-feedback d-block">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
						<div class="mb-3">
							<label class="form-label fw-semibold" for="name">Full Name <span class="text-danger">*</span></label>
							<input type="text" name="name" id="name" class="tt-input @error('name') is-invalid @enderror"
								   value="{{ old('name', $user->name) }}" required>
							@error('name')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-3">
							<label class="form-label fw-semibold" for="email">Email Address</label>
							<input type="email" class="tt-input" value="{{ $user->email }}" disabled>
							<div class="form-text text-muted">Email address cannot be changed here. Contact us to update it.</div>
						</div>
						<div class="mb-4">
							<label class="form-label fw-semibold" for="about">About Me <span class="text-muted fw-normal">(optional)</span></label>
							<textarea name="about" id="about" rows="4" class="tt-input @error('about') is-invalid @enderror"
									  placeholder="Tell us a little about yourself...">{{ old('about', $user->about) }}</textarea>
							@error('about')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="d-flex gap-3">
							<button type="submit" class="btn-tt-primary">
								<i class="fas fa-save me-2"></i>Save
							</button>
							<a href="{{ route('account.dashboard') }}" class="btn-tt-outline">Cancel</a>
						</div>
					</form>
				</div>

				<!-- Change Password -->
				<div class="tt-sidebar-card">
					<h5 class="fw-bold mb-4">
						<i class="fas fa-lock me-2" style="color:var(--tt-accent);"></i>Change Password
					</h5>
					<form action="{{ route('account.password.update') }}" method="POST">
						@csrf
						@method('PUT')
						<div class="mb-3">
							<label class="form-label fw-semibold" for="current_password">Current Password</label>
							<input type="password" name="current_password" id="current_password"
								   class="tt-input @error('current_password') is-invalid @enderror" required>
							@error('current_password')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-3">
							<label class="form-label fw-semibold" for="password">New Password</label>
							<input type="password" name="password" id="password"
								   class="tt-input @error('password') is-invalid @enderror"
								   minlength="8" required>
							<div class="form-text text-muted">Minimum 8 characters.</div>
							@error('password')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-4">
							<label class="form-label fw-semibold" for="password_confirmation">Confirm New Password</label>
							<input type="password" name="password_confirmation" id="password_confirmation"
								   class="tt-input" minlength="8" required>
						</div>
						<button type="submit" class="btn-tt-primary">
							<i class="fas fa-key me-2"></i>Update Password
						</button>
					</form>
				</div>

				<div class="text-center mt-4">
					<a href="{{ route('account.dashboard') }}" style="color:var(--tt-dark-soft);font-size:.9rem;">
						<i class="fas fa-arrow-left me-1"></i>Back to My Account
					</a>
				</div>
			</div>
		</div>
	</div>
</section>

@include('partials.footer')
@endsection
