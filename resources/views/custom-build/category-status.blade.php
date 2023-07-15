@if ((isset($overrideComponentVisibility->cat_status) && $overrideComponentVisibility->cat_status == 1) || (isset($overrideComponentVisibility->cat_status) && $overrideComponentVisibility->cat_status == 0))
  <div class="form-group clearfix">
    <div class="icheck-primary d-inline mr-3">
      <input type="radio" id="is_enable1-{{ $cat->id }}"
             name="customBuild[{{ $cat->id }}][is_enable]" value="1"
             class="is_enable1-{{ $cat->id }} component-status" @if (isset($overrideComponentVisibility->cat_status) && $overrideComponentVisibility->cat_status == 1) checked @endif data-headerId="com-header_com{{ $component->id }}">
      <label for="is_enable1-{{ $cat->id }}">Yes</label>
    </div>

    <div class="icheck-primary d-inline">
      <input type="radio" id="is_enable2-{{ $cat->id }}"
             name="customBuild[{{ $cat->id }}][is_enable]"
             class="is_enable2-{{ $cat->id }} component-status" value="0" @if (isset($overrideComponentVisibility->cat_status) && $overrideComponentVisibility->cat_status == 0) checked @endif data-headerId="com-header_com{{ $component->id }}">
      <label for="is_enable2-{{ $cat->id }}">No</label>
    </div>
  </div>
@else
  <div class="form-group clearfix">
    <div class="icheck-primary d-inline mr-3">
      <input type="radio" id="is_enable1-{{ $cat->id }}"
             name="customBuild[{{ $cat->id }}][is_enable]"
             class="is_enable1-{{ $cat->id }} component-status" value="1" checked data-headerId="com-header_com{{ $component->id }}">
      <label for="is_enable1-{{ $cat->id }}">Yes</label>
    </div>

    <div class="icheck-primary d-inline">
      <input type="radio" id="is_enable2-{{ $cat->id }}"
             name="customBuild[{{ $cat->id }}][is_enable]"
             class="is_enable2-{{ $cat->id }} component-status" value="0" data-headerId="com-header_com{{ $component->id }}">
      <label for="is_enable2-{{ $cat->id }}">No</label>
    </div>
  </div>
@endif
