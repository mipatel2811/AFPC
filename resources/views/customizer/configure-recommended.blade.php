<div class="configure-data">
  <ul>
    @php
      $price = 0;
    @endphp
    @foreach ($componentCategories as $key => $cat)
      @if (count($cat->getComponents))
        @php
          $componentSort = getCustomBuildComponentSortOrders($cat->id, $customBuild->id);
          $brands = getComponentBrands($cat->id);
        @endphp
        @foreach ($componentSort as $sortKey => $sortValue)
          @foreach ($cat->getComponents as $componentKey => $component)
            @php
              $overrideComponentVisibility = getCustomBuildOverrideComponentVisibility($cat->id, $component->id, $customBuild->id);
            @endphp
            @if ($overrideComponentVisibility->is_enable)
              @if ($component->id == $sortValue)
                @php
                  if (!empty($overrideComponentVisibility->mark_as) && $overrideComponentVisibility->mark_as != null) {
                      $mark = json_decode($overrideComponentVisibility->mark_as, true);
                  }
                @endphp
                @if (isset($mark) && !empty($mark) && $mark[0] == 'mark_as_recom' && $component->title != 'None')
                  <li>{{ $component->title }}</li>
                  @php
                    $price = $price + $overrideComponentVisibility->regular_price;
                  @endphp
                @endif
              @endif
            @endif
          @endforeach
        @endforeach
      @endif
    @endforeach
  </ul>
  <div class="configure-price-box">
    <span>SGD ${{ $price }}</span>
    @if (isset($productURL) && !empty($productURL))
      <a class="button btn-xs" href="{{ $productURL }}?type=recom">CUSTOMIZE</a>
    @else
      <a class="button btn-xs" href="#">CUSTOMIZE</a>
    @endif
  </div>
</div>
