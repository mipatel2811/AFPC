<div class="card-body">
  <div class="form-group">
    {{ Form::label('title', 'Custom Build Title', ['class' => 'control-label required']) }}
    {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Custom Build title']) }}
    @if ($errors->has('title'))
      <span class="text-danger">{{ $errors->first('title') }}</span>
    @endif
  </div>
  <div class="form-group summernotediv">
    {{ Form::label('description', 'Custom Build Description', ['class' => 'control-label required']) }}
    {{ Form::textarea('description', null, ['required' => 'required', 'data-msg' => 'Please write Custom Build Description', 'class' => 'form-control summernote', 'id' => 'summernote', 'rows' => 10]) }}
    @if ($errors->has('description'))
      <span class="text-danger">{{ $errors->first('description') }}</span>
    @endif
  </div>
  <div class="row">
    <div class="col-lg-6 col-6">
      <div class="form-group">
        {{ Form::label('custom_build_category_id', 'Custom Build Category', ['class' => 'control-label required']) }}
        {{ Form::select('custom_build_category_id', $customBuildCategories, null, ['class' => 'form-control custom-build-category', 'placeholder' => 'Custom Build Category']) }}
        @if ($errors->has('custom_build_category_id'))
          <span class="text-danger">{{ $errors->first('custom_build_category_id') }}</span>
        @endif
      </div>
    </div>
    <div class="col-lg-6 col-6">
      <div class="form-group">
        {{ Form::label('sku', 'Custom Build SKU', ['class' => 'control-label']) }}
        {{ Form::text('sku', null, ['class' => 'form-control', 'placeholder' => 'Custom Build SKU']) }}
        @if ($errors->has('sku'))
          <span class="text-danger">{{ $errors->first('sku') }}</span>
        @endif
      </div>
    </div>
  </div>
  <div class="form-group">
    {{ Form::label('tags', 'Tags', ['class' => 'control-label']) }}
    {{ Form::select('tags[]', [], null, ['class' => 'form-control js-example-tags', 'multiple' => 'multiple', 'placeholder' => 'Custom Build tags']) }}
    @if ($errors->has('tags'))
      <span class="text-danger">{{ $errors->first('tags') }}</span>
    @endif
  </div>
  <div class="form-group">
    {{ Form::label('images', 'Gallery', ['class' => 'control-label required']) }}
    <div class="input-group">
      <div class="custom-file">
        <input name="images[]" type="file" class="custom-file-input" id="image" multiple accept="image/png,image/jpeg" />
        <label class="custom-file-label" for="images">Choose file</label>
      </div>
    </div>
    @if ($errors->has('images'))
      <span class="text-danger">{{ $errors->first('images') }}</span>
    @endif
    @if (isset($componentCategory->image) && $componentCategory->image != '')
      <br />
      <img src="{{ asset('/public/img/component-categories/' . $componentCategory->image . '') }}" height='100'>
    @endif
  </div>

  <div class="form-group">
    {{ Form::label('product_video', 'Product Video', ['class' => 'control-label']) }}
    <div class="form-group clearfix">
      <div class="icheck-primary d-inline mr-3">
        <input type="radio" id="product_video1" class="product_video" name="product_video" value="1">
        <label for="product_video1">Yes</label>
      </div>
      <div class="icheck-primary d-inline">
        <input type="radio" id="product_video2" class="product_video" name="product_video" value="0" checked>
        <label for="product_video2">No</label>
      </div>
    </div>
    <span class="js-error_product_video"></span>
  </div>
  <div class="product_video_wrap"> </div>
  <div class="form-group">
    {{ Form::label('technical_specification', 'Technical Specification', ['class' => 'control-label']) }}
    <div class="form-group clearfix">
      <div class="icheck-primary d-inline mr-3">
        <input type="radio" id="technical_specification1" class="technical_specification" name="technical_specification" value="1">
        <label for="technical_specification1">Yes</label>
      </div>
      <div class="icheck-primary d-inline">
        <input type="radio" id="technical_specification2" class="technical_specification" name="technical_specification" value="0" checked>
        <label for="technical_specification2">No</label>
      </div>
    </div>
    <span class="js-error_technical_specification"> </span>
  </div>
  <div class="technical_specification_wrap"> </div>
  <div class="form-group">
    {{ Form::label('is_active', 'Is Active', ['class' => 'control-label']) }}
    <div class="form-group clearfix">
      <div class="icheck-primary d-inline mr-3">
        <input type="radio" id="is_active1" name="is_active" value="1" checked>
        <label for="is_active1">Yes</label>
      </div>

      <div class="icheck-primary d-inline">
        <input type="radio" id="is_active2" name="is_active" value="0">
        <label for="is_active2">No</label>
      </div>
    </div>
    <span class="js-error_is_active"></span>
  </div>
  <div class="form-group">
    {{ Form::label('promotion_id', 'Select Promotion', ['class' => 'control-label']) }}
    <div class="form-group clearfix">
      <select class="form-control" name="promotion_id">
        <option>Select Option</option>
        @foreach ($promotions as $pkry => $promotion)
          <option value="{{ $pkry }}">{{ $promotion }}</option>
        @endforeach
      </select>
    </div>
    <span class="js-error_promotion_id"></span>
  </div>


  <div class="form-group">
    <div class="bs-example">
      <div class="accordion" id="accordionExample">
        @php
          $radiocounter = 0;
          $orradiocounter = 0;
          $parentWrapSort = [];
        @endphp

        @foreach ($componentCategories as $key => $cat)
          @php
            $parentWrapSort[$key] = $cat->id;
            $childSort = [];
          @endphp
          <div class="card ui-state-default" id="parentWrapSort_{{ $cat->id }}">
            <div class="card-header bg-primary" id="com-header_cat{{ $cat->id }}">
              <h2 class="mb-0">
                <a type="button" class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseOne-cat{{ $cat->id }}"><i
                     class="fa fa-plus"></i> &nbsp;&nbsp;&nbsp; {{ $cat->title }} </a>
              </h2>
            </div>
            <div id="collapseOne-cat{{ $cat->id }}" class="collapse"
                 aria-labelledby="{{ $cat->id }}" data-parent="#accordionExample">
              <div class="card-body">
                <div class="accordion component-sorting" id="collapseOne-component{{ $cat->id }}">
                  @php
                    $childKey = 0;
                  @endphp
                  @foreach ($cat->getComponents as $componentKey => $component)
                    @php
                      $childSort[] = $component->id;
                    @endphp
                    <div class="card ui-state-default cateId_{{ $cat->id }}" id="childSort_{{ $component->id }}">
                      <div class="card-header bg-secondary" id="com-header_com{{ $component->id }}">
                        <h2 class="mb-0">
                          <a type="button" class="btn btn-link text-white" data-toggle="collapse"
                             data-target="#component-com{{ $component->id }}"><i class="fa fa-plus"></i> &nbsp;&nbsp;&nbsp;
                            {{ $component->title }}
                          </a>
                        </h2>
                      </div>
                      <div id="component-com{{ $component->id }}" class="collapse"
                           data-parent="#collapseOne-component{{ $cat->id }}">
                        @if (isset($component->getComponentVisibility))
                          <div class="card-body">
                            <div class="accordion" id="condition-component{{ $component->id }}">
                              <div class="card ">
                                <div class="card-header bg-primary" id="com-header_con{{ $component->id }}">
                                  <h2 class="mb-0">
                                    <a type="button" class="btn btn-link text-white" data-toggle="collapse"
                                       data-target="#condition-con{{ $component->id }}"><i class="fa fa-plus"></i> &nbsp;&nbsp;&nbsp;
                                      Conditions
                                    </a>
                                  </h2>
                                </div>
                                <div id="condition-con{{ $component->id }}" class="collapse"
                                     data-parent="#condition-component{{ $component->id }}" style="padding: 18px;">
                                  <div class="add-rowrulegroup parent_wrap_{{ $component->id }}">
                                    @php
                                      $rowCount = 0;
                                    @endphp

                                    @foreach (json_decode($component->getComponentVisibility->conditions, true) as $key => $orConditions)
                                      <div class="add-row_{{ $rowCount }}">
                                        @foreach ($orConditions as $value)
                                          <div class="form-group condition-row">
                                            @if ($rowCount > 0)
                                              <div class="form-group">
                                                {{ Form::label('select_condition_to_display', 'Or', ['class' => 'control-label required']) }}
                                              </div>
                                            @endif
                                            {{ Form::label('select_condition_to_display', 'Select Condition to display', ['class' => 'control-label required']) }}
                                            <div class="row">
                                              <div class="col-lg-4 col-4">
                                                <div class="form-group">
                                                  {{ Form::text(null, null, ['class' => 'form-control', 'placeholder' => 'Component', 'readonly']) }}
                                                </div>
                                              </div>
                                              <div class="col-lg-2 col-2">
                                                <div class="form-group">
                                                  {{ Form::text(null, null, ['class' => 'form-control', 'placeholder' => 'is equal to', 'readonly']) }}
                                                </div>
                                              </div>
                                              <div class="col-lg-4 col-4">
                                                <select class="form-control overwrite-component"
                                                        name="customBuild[{{ $cat->id }}][{{ $component->id }}][conditions][{{ $rowCount }}][]"
                                                        aria-invalid="false">
                                                  <?php foreach ($componentSelect as $componentKey => $componentCategory) { ?>
                                                  <option value="{{ $componentKey }}" @if ($componentKey == $value) selected="" @endif>{{ $componentCategory }}</option>
                                                  <?php } ?>
                                                </select>
                                              </div>

                                              <div class="col-lg-2 col-2">
                                                <a href="javascript:void(0)" class="btn btn-primary add_form_field"
                                                   data-andcount="{{ $rowCount }}"
                                                   onclick="addRow('{{ $rowCount }}','{{ $cat->id }}','{{ $component->id }}')"> And </a>
                                                <a href="javascript:void(0)"
                                                   class="btn btn-danger delete" data-andcount="{{ $rowCount }}"
                                                   onclick="deleteRow('{{ $rowCount }}','{{ $component->id }}')"> - </a>
                                              </div>

                                            </div>

                                          </div>

                                        @endforeach
                                      </div>
                                      @php
                                        $rowCount++;
                                      @endphp
                                    @endforeach
                                  </div>

                                  <div class="form-group">
                                    <a type="javascript:void(0)" class="btn btn-primary rule-group"
                                       onclick="exitOrAddRow('{{ $cat->id }}','{{ $component->id }}')">add rule group</a>
                                  </div>

                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-lg-6 col-6">
                                <div class="form-group">
                                  {{ Form::label('regular_price', 'Regular Price', ['class' => 'control-label']) }}
                                  <input type="text" name="customBuild[{{ $cat->id }}][{{ $component->id }}][regular_price]"
                                         class="form-control regular_price-{{ $component->id }}" placeholder="Regular Price" required>
                                  @if ($errors->has('regular_price'))
                                    <span class="text-danger">{{ $errors->first('regular_price') }}</span>
                                  @endif
                                </div>
                              </div>
                              <div class="col-lg-6 col-6">
                                <div class="form-group">
                                  {{ Form::label('special_price', 'Special Price', ['class' => 'control-label']) }}
                                  <input type="text" name="customBuild[{{ $cat->id }}][{{ $component->id }}][special_price]"
                                         class="form-control special_price-{{ $component->id }}" placeholder="Special Price" required>
                                  @if ($errors->has('special_price'))
                                    <span class="text-danger">{{ $errors->first('special_price') }}</span>
                                  @endif
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-lg-6 col-6">
                                <div class="form-group">
                                  {{ Form::label('Enable', 'Is Enable', ['class' => 'control-label']) }}
                                  <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline mr-3">
                                      <input type="radio" id="is_enable1-{{ $radiocounter }}"
                                             name="customBuild[{{ $cat->id }}][{{ $component->id }}][is_enable]" value="1"
                                             class="is_enable1-{{ $component->id }} component-status"
                                             data-componentid="{{ $component->id }}">
                                      <label for="is_enable1-{{ $radiocounter }}">Yes</label>
                                    </div>

                                    <div class="icheck-primary d-inline">
                                      <input type="radio" id="is_enable2-{{ $radiocounter }}"
                                             name="customBuild[{{ $cat->id }}][{{ $component->id }}][is_enable]"
                                             class="is_enable2-{{ $component->id }} component-status"
                                             data-componentid="{{ $component->id }}" value="0" checked>
                                      <label for="is_enable2-{{ $radiocounter }}">No</label>
                                    </div>
                                  </div>
                                  <span class="js-error_is_enable"></span>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-lg-6 col-6">
                                <div class="form-group">
                                  {{ Form::label('Mark As', 'Mark As', ['class' => 'control-label']) }}
                                  <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline mr-3">
                                      <input type="checkbox" id="mark_as1-{{ $radiocounter }}"
                                             name="customBuild[{{ $cat->id }}][{{ $component->id }}][mark_as][]" value="mark_as"
                                             class="mark_as_{{ $cat->id }}" onchange="checkMarkAs({{ $cat->id }})">
                                      <label for="mark_as1-{{ $radiocounter }}">Mark as Base</label>
                                    </div>

                                    <div class="icheck-primary d-inline">
                                      <input type="checkbox" id="mark_as2-{{ $radiocounter }}"
                                             name="customBuild[{{ $cat->id }}][{{ $component->id }}][mark_as][]" value="mark_as_recom"
                                             class="mark_as_recom_{{ $cat->id }}" onchange="checkMarkAs({{ $cat->id }})">
                                      <label for="mark_as2-{{ $radiocounter }}">Mark as Recommendation</label>
                                    </div>
                                  </div>
                                  <span class="js-error_mark_as"></span>
                                </div>
                              </div>
                            </div>

                            <div class="form-group">
                              <a type="javascript:void(0)" class="btn btn-outline-primary restore-default" data-id="{{ $component->id }}"
                                 data-cateId="{{ $cat->id }}">Restore
                                Default</a>
                            </div>
                            @php
                              $radiocounter++;
                            @endphp
                          </div>
                        @else
                          <div class="card-body">
                            <div class="accordion" id="condition-component{{ $component->id }}">
                              <div class="card ">
                                <div class="card-header bg-primary" id="com-header_con{{ $component->id }}">
                                  <h2 class="mb-0">
                                    <a type="button" class="btn btn-link text-white" data-toggle="collapse"
                                       data-target="#condition-con{{ $component->id }}"><i class="fa fa-plus"></i> &nbsp;&nbsp;&nbsp;
                                      Conditions
                                    </a>
                                  </h2>
                                </div>
                                <div id="condition-con{{ $component->id }}" class="collapse"
                                     data-parent="#condition-component{{ $component->id }}" style="padding: 18px;">
                                  <div class="add-rowrulegroup parent_wrap_{{ $component->id }}"></div>
                                  <div class="form-group">
                                    <a type="javascript:void(0)" class="btn btn-primary rule-group"
                                       onclick="exitOrAddRow('{{ $cat->id }}','{{ $component->id }}')">add rule group</a>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-lg-6 col-6">
                                <div class="form-group">
                                  {{ Form::label('regular_price', 'Regular Price', ['class' => 'control-label']) }}
                                  <input type="text" name="customBuild[{{ $cat->id }}][{{ $component->id }}][regular_price]"
                                         class="form-control regular_price-{{ $component->id }}" placeholder="Regular Price" required>
                                  @if ($errors->has('regular_price'))
                                    <span class="text-danger">{{ $errors->first('regular_price') }}</span>
                                  @endif
                                </div>
                              </div>
                              <div class="col-lg-6 col-6">
                                <div class="form-group">
                                  {{ Form::label('special_price', 'Special Price', ['class' => 'control-label']) }}
                                  <input type="text" name="customBuild[{{ $cat->id }}][{{ $component->id }}][special_price]"
                                         class="form-control special_price-{{ $component->id }}" placeholder="Special Price" required>
                                  @if ($errors->has('special_price'))
                                    <span class="text-danger">{{ $errors->first('special_price') }}</span>
                                  @endif
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-lg-6 col-6">
                                <div class="form-group">
                                  {{ Form::label('Enable', 'Is Enable', ['class' => 'control-label']) }}
                                  <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline mr-3">
                                      <input type="radio" id="oris_enable1-{{ $orradiocounter }}"
                                             name="customBuild[{{ $cat->id }}][{{ $component->id }}][is_enable]" value="1"
                                             class="is_enable1-{{ $component->id }} component-status"
                                             data-componentid="{{ $component->id }}">
                                      <label for="oris_enable1-{{ $orradiocounter }}">Yes</label>
                                    </div>

                                    <div class="icheck-primary d-inline">
                                      <input type="radio" id="oris_enable2-{{ $orradiocounter }}"
                                             name="customBuild[{{ $cat->id }}][{{ $component->id }}][is_enable]" value="0"
                                             class="is_enable2-{{ $component->id }} component-status"
                                             data-componentid="{{ $component->id }}" checked>
                                      <label for="oris_enable2-{{ $orradiocounter }}">No</label>
                                    </div>
                                  </div>
                                  <span class="js-error_is_enable"></span>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-lg-6 col-6">
                                <div class="form-group">
                                  {{ Form::label('Mark As', 'Mark As', ['class' => 'control-label']) }}
                                  <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline mr-3">
                                      <input type="checkbox" id="ormark_as1-{{ $orradiocounter }}"
                                             name="customBuild[{{ $cat->id }}][{{ $component->id }}][mark_as][]" value="mark_as"
                                             class="mark_as_{{ $cat->id }}" onchange="checkMarkAs({{ $cat->id }})">
                                      <label for="ormark_as1-{{ $orradiocounter }}">Mark as Base</label>
                                    </div>

                                    <div class="icheck-primary d-inline">
                                      <input type="checkbox" id="ormark_as2-{{ $orradiocounter }}"
                                             name="customBuild[{{ $cat->id }}][{{ $component->id }}][mark_as][]" value="mark_as_recom"
                                             class="mark_as_recom_{{ $cat->id }}" onchange="checkMarkAs({{ $cat->id }})">
                                      <label for="ormark_as2-{{ $orradiocounter }}">Mark as Recommendation</label>
                                    </div>
                                  </div>
                                  <span class="js-error_mark_as"></span>
                                </div>
                              </div>
                            </div>

                            <div class="form-group">
                              <a type="javascript:void(0)" class="btn btn-outline-primary restore-default" data-id="{{ $component->id }}"
                                 data-cateId="{{ $cat->id }}">Restore
                                Default</a>
                            </div>
                          </div>
                          @php
                            $orradiocounter++;
                          @endphp
                        @endif
                        @php
                          $childKey++;
                        @endphp
                      </div>
                    </div>
                  @endforeach
                  <input type="hidden" id="childSortId_{{ $cat->id }}" name="childSort[{{ $cat->id }}]"
                         value="{{ json_encode($childSort, JSON_FORCE_OBJECT) }}" />
                </div>
                <div class="row">
                  <div class="col-lg-6 col-6">
                    <div class="form-group">
                      {{ Form::label('Enable', 'Is Enable', ['class' => 'control-label']) }}
                      <div class="form-group clearfix">
                        <div class="icheck-primary d-inline mr-3">
                          <input type="radio" id="is_enable1-{{ $cat->id }}"
                                 name="customBuild[{{ $cat->id }}][is_enable]" value="1"
                                 class="is_enable1-{{ $cat->id }}" checked>
                          <label for="is_enable1-{{ $cat->id }}">Yes</label>
                        </div>

                        <div class="icheck-primary d-inline">
                          <input type="radio" id="is_enable2-{{ $cat->id }}"
                                 name="customBuild[{{ $cat->id }}][is_enable]"
                                 class="is_enable2-{{ $cat->id }}" value="0">
                          <label for="is_enable2-{{ $cat->id }}">No</label>
                        </div>
                      </div>
                      <span class="js-error_is_enable"></span>
                    </div>
                    <div class="form-group">
                      <a type="javascript:void(0)" class="btn btn-outline-primary restore-default-cate" data-id="{{ $component->id }}"
                         data-cateId="{{ $cat->id }}">Restore Default</a>
                      <a type="javascript:void(0)" class="btn btn-outline-primary sort-enabled" data-id="{{ $component->id }}"
                         data-cateId="{{ $cat->id }}">Sort Enabled</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
        <input type="hidden" id="customBuildCatSortId" name="customBuildCatSort" value="{{ json_encode($parentWrapSort, JSON_FORCE_OBJECT) }}" />
      </div>
    </div>
  </div>

</div>
<style>
  .displayNone {
    display: none !important;
  }

</style>
<!-- /.card-body -->
