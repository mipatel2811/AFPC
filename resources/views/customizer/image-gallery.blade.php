<div class="gallery-section">
  <div class="wrap">
    {{-- <div class="heading-box">
      <h3>GALLERY</h3>
    </div> --}}
    <div class="gallery-slider-box">
      <div class="slider-for">
        @foreach ($imageGalleries as $gallery)
          <figure><img src="{{ asset('/public/img/custom-build/gallery/' . $gallery . '') }}" /></figure>
        @endforeach
      </div>
      <div class="slider-nav">
        @foreach ($imageGalleries as $gallery)
          <figure><img src="{{ asset('/public/img/custom-build/gallery/' . $gallery . '') }}" /></figure>
        @endforeach
      </div>
    </div>
  </div>
</div>
<script>

</script>
