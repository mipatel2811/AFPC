        @php
          if (!empty($overrideComponentVisibility->mark_as) && $overrideComponentVisibility->mark_as != null) {
              $mark = json_decode($overrideComponentVisibility->mark_as, true);
          }
        @endphp
        <div class="col">
          <label>
            <input type="radio" id="compo_{{ $component->id }}" class="parent disable_child_category_{{ $component->id }}"
                   value="{{ $component->id }}"
                   name="component[{{ $cat->id }}][]" @if (isset($mark) && !empty($mark) && $mark[0] == 'mark_as' && $product_type == 'base') checked @endif
                   @if (isset($mark) && !empty($mark) && $mark[0] == 'mark_as_recom' && $product_type == 'recom')
            checked @endif/>
            <div class="customizer-data-box">
              <div class="img-box">
                <img src="{{ asset('/public/img/components/' . $component->image . '') }}" alt="" style="width: 100%;">
              </div>
              <div class="customizer-data">
                <p>{{ $component->title }}
                  @if (isset($mark) && !empty($mark) && $mark[0] == 'mark_as')
                    <span style="color:#00deff;">(Base)</span>
                  @endif
                  @if (isset($mark) && !empty($mark) && $mark[0] == 'mark_as_recom')
                    <span style="color:#ff0000;">(Recommended)</span>
                  @endif
                </p>
                <span>+ SGD {{ number_format($overrideComponentVisibility->regular_price, 2) }}</span>
                <div class="data-btn">
                  <a href="#" class="button btn-xs">Select</a>
                  <a href="#" class="learn-more">Learn more</a>
                </div>
              </div>
            </div>
          </label>
        </div>
