@if ((isset($overrideComponentVisibility->is_enable) && $overrideComponentVisibility->is_enable == 1) || isset($overrideComponentVisibility->is_enable) && $overrideComponentVisibility->is_enable == 0)
  <div class="icheck-primary d-inline mr-3">
    <input type="radio" id="oris_enable1-{{ $orradiocounter }}"
           name="customBuild[{{ $cat->id }}][{{ $component->id }}][is_enable]" value="1" @if (isset($overrideComponentVisibility->is_enable) && $overrideComponentVisibility->is_enable == 1) checked @endif class="component-status"
           data-componentid="{{ $component->id }}">
    <label for="oris_enable1-{{ $orradiocounter }}">Yes</label>
  </div>

  <div class="icheck-primary d-inline">
    <input type="radio" id="oris_enable2-{{ $orradiocounter }}"
           name="customBuild[{{ $cat->id }}][{{ $component->id }}][is_enable]" value="0" @if (isset($overrideComponentVisibility->is_enable) && $overrideComponentVisibility->is_enable == 0) checked @endif class="component-status"
           data-componentid="{{ $component->id }}">
    <label for="oris_enable2-{{ $orradiocounter }}">No</label>
  </div>
@else
  <div class="icheck-primary d-inline mr-3">
    <input type="radio" id="oris_enable1-{{ $orradiocounter }}"
           name="customBuild[{{ $cat->id }}][{{ $component->id }}][is_enable]" value="1" class="component-status"
           data-componentid="{{ $component->id }}">
    <label for="oris_enable1-{{ $orradiocounter }}">Yes</label>
  </div>

  <div class="icheck-primary d-inline">
    <input type="radio" id="oris_enable2-{{ $orradiocounter }}"
           name="customBuild[{{ $cat->id }}][{{ $component->id }}][is_enable]" value="0" checked class="component-status"
           data-componentid="{{ $component->id }}">
    <label for="oris_enable2-{{ $orradiocounter }}">No</label>
  </div>
@endif
