<div style="--w: ;--h: "
	class='photo' {{-- ${disabled ? `disabled` : ``}'--}} 
	data-album-id='{{ $album_id }}'
	data-id='{{ $photo_id }}'
	data-tabindex='{{ Helpers::data_index() }}'
	>

	@if ($show_live) 
		@include('components.photo.thumb-live')

	@elseif ($show_play)
		@include('components.photo.thumb-play')

	@elseif ($show_placeholder)
		@include('components.photo.thumb-placeholder')
	
	@else
		@include('components.photo.thumbimg')
	@endif

	<div class='overlay'>
		<h1 title='{{ $title }}'>{{ $title }}</h1>

	@if ($takedate !== "") 
		<a><span title='Camera Date'><svg class='iconic'><use xlink:href='#camera-slr' /></svg></span>{{ $takedate }}</a>
	@else
		<a>{{ $sysdate }}</a>
	@endif
	</div>

	@if (AccessControl::is_logged_in())
		<div class='badges'>
			@if($star)
			<x-icon class='badge--star icn-star' icon='star' />
			@endif
			@if($public // && album.json.public !== "1"
			)
			<x-icon class='badge--visible badge--hidden icn-share' icon='eye' />
			@endif
		</div>
	@endif
</div>