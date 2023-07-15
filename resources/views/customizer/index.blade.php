  <div class="customizer-product-box">

    {{-- PROMOTION --}}
    @if (isset($customBuild->getCustomBuildPromotion))
      <div class="accordion-databox">
        <div class="heading-box">
          <h3>PROMOTION</h3>
          <p>Enjoy a sweet discount for this season’s promotion!</p>
        </div>
        <div class="customizer-product-section">
          <div class="">
            <img src="{{ asset('public/img/promotion/' . $customBuild->getCustomBuildPromotion->image) }}" alt="">
          </div>
        </div>
      </div>
    @endif
    {{-- End PROMOTION --}}
    <div class="accordion-databox">
      <div class="heading-box">
        <h3>CORE COMPONENTS</h3>
        <p>Customize your own PC with premium components. </p>
      </div>
      @foreach ($componentCategories as $key => $cat)
        @if (count($cat->getComponents))
          @php
            $componentSort = getCustomBuildComponentSortOrders($cat->id, $customBuild->id);
            $brands = getComponentBrands($cat->id);
          @endphp
          <div class="customizer-product-section">
            <div class="accordion-row">
              <div class="accordion-trigger">
                <div class="accordion-box">
                  <div class="accordion-img">
                    <img src="{{ asset('/public/img/component-categories/' . $cat->image . '') }}" alt="">
                  </div>
                  <div class="accordion-info">
                    <h5>{{ $cat->title }}</h5>
                    <p>{!! $cat->description !!}</p>
                    {{-- <span> + SGD 0.00</span> --}}
                  </div>
                </div>
              </div>
              <div class="accordion-data">
                @if ($brands[0]['id'] != '')
                  <p>Choose your {{ $cat->title }} Brand.</p>
                  <div class="choose-brand-data ">
                    <div class="tab-data">
                      <ul class="tabnav">
                        @foreach ($brands as $brandkey => $brand)
                          @if ($brand['id'] != '')
                            <li><a href="#" class="button btn-secondary @if ($brandkey=='0' ) active @endif" data-rel="cpu_{{ $brand['id'] }}">{{ $brand['title'] }}</a> </li>
                          @endif
                        @endforeach
                      </ul>
                      <div class="tab-container">
                        @foreach ($brands as $brandDatakey => $brandData)
                          <div class="tabcontent" id="cpu_{{ $brandData['id'] }}">
                            <div class="cols4 cols">
                              @foreach ($componentSort as $sortKey => $sortValue)
                                @foreach ($cat->getComponents as $componentKey => $component)
                                  @if ($component->id == $sortValue)
                                    @php
                                      $overrideComponentVisibility = getCustomBuildOverrideComponentVisibility($cat->id, $component->id, $customBuild->id);
                                    @endphp
                                    @if ($overrideComponentVisibility->is_enable)
                                      @if ($brandData['id'] == $component->brand_id)
                                        @include('customizer.component-col')
                                      @elseif ($brandData['id'] == '' || $component->brand_id==null)
                                        @include('customizer.component-col')
                                      @endif
                                    @endif
                                  @endif
                                @endforeach
                              @endforeach
                            </div>
                          </div>
                        @endforeach
                      </div>
                    </div>
                  </div>
                @else
                  {{-- <p>{!! $cat->description !!}</p> --}}
                  <div class="cols4 cols">
                    @foreach ($componentSort as $sortKey => $sortValue)
                      @foreach ($cat->getComponents as $componentKey => $component)
                        @php
                          $overrideComponentVisibility = getCustomBuildOverrideComponentVisibility($cat->id, $component->id, $customBuild->id);
                        @endphp
                        @if ($overrideComponentVisibility->is_enable)
                          @if ($component->id == $sortValue)
                            @include('customizer.component-col')
                          @endif
                        @endif
                      @endforeach
                    @endforeach
                  </div>
                @endif
              </div>
              <!--/.accordion-data -->
            </div>
            <!--/.accordion-row -->
          </div>
        @endif
      @endforeach
    </div>
  </div>



  <div class="customizer-sidebar">
    <div class="sidebar">
      <div class="sidebar-title">
        <h2>{{ $customBuild->title }}</h2>
      </div>
      <div class="sidebar-box">
        <div class="sidebar-img">
          @if (isset($imageGallery[0]))
            <img src="{{ asset('/public/img/custom-build/gallery/') }}/{{ $imageGallery[0] }}" alt="" style="width: 100%;">
          @endif
        </div>
        <div class="customizer-infobox">
          <div class="customisation-summary-btn">
            <a class="poptrigger" href="#" data-rel="rapid-popup">
              <img src="{{ asset('/public/images/note.png') }}" alt="">
              Customisation Summary
            </a>
          </div>
          <div class="promotion-text">
            <h6>Back to School Promotion</h6>
            <p>Get up to $300 Off with our current promotion. </p>
          </div>
          <div class="info-links">
            <ul>
              <li><a href="#">
                  <img src="{{ asset('/public/images/save.png') }}" alt="">
                  <p>Save</p>
                </a></li>
              <li><a href="#">
                  <img src="{{ asset('/public/images/share.png') }}" alt="">
                  <p>Share</p>
                </a></li>
              <li> <a href="#">
                  <img src="{{ asset('/public/images/faq.png') }}" alt="">
                  <p>Faq</p>
                </a></li>
              <li><a href="#">
                  <img src="{{ asset('/public/images/email.png') }}" alt="">
                  <p>Email</p>
                </a></li>
            </ul>
          </div>
          <div class="subtotal-box">
            <p>SUBTOTAL</p>
            <span>SGD 1135</span>
            <a href="#" class="button btn-lg">ADD TO CART</a>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="popouterbox" id="rapid-popup">
    <div class="popup-block">
      <div class="pop-contentbox">
        <div class="rapid-title">
          <a href="#" class="close-dialogbox"><i class="icon-close"></i></a>
          <h5>RAPID Black Mesh High Airflow Tempered Glass Chassis</h5>
        </div>
        <div class="rapid-desc-popup">
          <div class="cols2 cols">
            <div class="col">
              @if (isset($imageGallery[0]))
                <figure><img src="{{ asset('/public//img/custom-build/gallery/') }}/{{ $imageGallery[0] }}" alt="" style="width: 100%;">
                </figure>
              @endif
            </div>
            <div class="col">
              <h5>SPECIFICATIONS</h5>
              <ul>
                <li>Dimension: 200 mm x 450 mm x 455 mm / 7.8 in x 17.7 in x 17.9 in (WxHxD)</li>
                <li>Form Factor: Mid Tower</li>
                <li>Material(s): Steel Chassis, Tempered Glass</li>
                <li>Motherboard: Support ATX, uATX, mITX, (E-ATX* - up to 285mm wide)</li>
                <li>Front I/O: 2x USB 3.0, Mic, Headphone, D-RGB LED SW</li>
                <li>Side Window: Yes, Tempered Glass</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!--/.pop-contentbox-->
    </div>
    <!--/.popup-block-->
  </div>
  @php
    $conditions = getVisibility($customBuild->id);
  @endphp

  <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">

  <script src="{{ asset('public/lara-js/vendor/jquery.matchHeight-min.js') }}"></script>
  <script src="{{ asset('public/lara-js/general.js') }}"></script>
  <script>

    var conditions = '{{ $conditions }}';
    var conditionsJSON = JSON.parse(conditions.replace(/&quot;/g, '"'));

    $(document).ready(function() {
      checkVisiblity();
    });
    $(".parent").change(function(e) {
      checkVisiblity();
    });

    function checkVisiblity() {
      if (typeof conditionsJSON != "undefined") {
        // console.log(conditionsJSON);

        $.each(conditionsJSON, function(key, value) {
          //   console.log("Key " + key);
          //   console.log("value " + value);
          var current_component = key;
          var main_flag = 0;
          $.each(value.conditions, function(innerKry, innerValue) {
            // console.log(innerValue.length);
            // console.log(innerValue);
            // console.log(innerValue[0]);
            if (innerValue.length > 1) {
              var sub_flag = 1;
              $.each(innerValue, function(innercomponentkey, innercomponentValue) {
                if (!$('.parent[value="' + innercomponentValue + '"]').is(':checked')) {
                  sub_flag = 0;
                }
              });
              //   console.log("SUbflag = " + sub_flag);

              if (sub_flag == 1) {
                main_flag = 1;
              }

            } else {
              //   console.log($('.parent[value="' + innerValue + '"]'));
              if ($('.parent[value="' + innerValue + '"]').is(':checked')) {
                main_flag = 1;
              }
            }
            // console.log("Innerkey = " + innerKry);
          });
          if (main_flag == 1) {
            $('#compo_' + key).prop('disabled', false);
            $('#compo_' + key).parent().attr('title', '');
            $('#compo_' + key).next("div").removeClass('disabled-component');
          } else {
            $('#compo_' + key).prop('disabled', true);
            $('#compo_' + key).parent().attr('title', value.message_on_disable);
            $('#compo_' + key).next("div").addClass('disabled-component');
          }
        });
      }
    }
  </script>
