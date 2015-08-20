<div class="container">
  <div class="row feature-12">
    <div class="col-md-8">
      <img
        src="{!! asset('img/logo-main.png') !!}"
        class="img-responsive">
      <p>
        {{ $business->statement }}
      </p>
    </div>
    <div class="col-md-4 hidden-sm hidden-xs">
      <i class="{{ $business->cssClass }}"></i>
    </div>
  </div>
</div>
