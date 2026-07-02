{{-- Expects: $destination --}}
@auth
	@if(auth()->user()->hasWishlisted($destination))
	<form action="{{ route('wishlist.destroy', $destination->id) }}" method="POST" class="tt-save-form">
		@csrf
		@method('DELETE')
		<button type="submit" class="btn-save-wishlist is-saved">
			<i class="fas fa-heart"></i> Saved
		</button>
	</form>
	@else
	<form action="{{ route('wishlist.store', $destination->id) }}" method="POST" class="tt-save-form">
		@csrf
		<button type="submit" class="btn-save-wishlist">
			<i class="far fa-heart"></i> Save to Wishlist
		</button>
	</form>
	@endif
@else
	<a href="{{ route('login') }}" class="btn-save-wishlist">
		<i class="far fa-heart"></i> Save to Wishlist
	</a>
@endauth
