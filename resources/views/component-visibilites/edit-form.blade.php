<div class="card-body">

  <div class="form-group">
    {{ Form::label('component_id', 'Select Component', ['class' => 'control-label required']) }}
    @if (isset($component) && $component->component_id != null)
      {{ Form::select('component_id', $componentCategories, $component->component_id, ['class' => 'form-control js-example-tags']) }}
    @else
      {{ Form::select('component_id', $componentCategories, null, ['class' => 'form-control js-example-tags']) }}
    @endif
    @if ($errors->has('component_id'))
      <span class="text-danger">{{ $errors->first('component_id') }}</span>
    @endif
  </div>
  <div class="form-group summernotediv">
    {{ Form::label('description', 'Component visibility Description', ['class' => 'control-label required']) }}
    {{ Form::textarea('description', null, ['required' => 'required', 'data-msg' => 'Please write Component visibility Description', 'class' => 'form-control summernote', 'id' => 'summernote', 'rows' => 10]) }}
    @if ($errors->has('description'))
      <span class="text-danger">{{ $errors->first('description') }}</span>
    @endif
  </div>

  <div class="add-rowrulegroup">
    @php
      $rowCount = 0;
    @endphp
    @foreach (json_decode($component['conditions'], true) as $key => $orConditions)
      <div class="add-row_{{ $rowCount }}">
        @if ($rowCount > 0)
          <div class="form-group">
            {{ Form::label('select_condition_to_display', 'Or', ['class' => 'control-label required']) }}
          </div>
        @endif
        @foreach ($orConditions as $orCondition)
          <div class="form-group condition-row">
            {{ Form::label('select_condition_to_display', 'Select Condition to display', ['class' => 'control-label required']) }}
            <div class="row">
              <div class="col-lg-4 col-4">
                <div class="form-group"> {{ Form::text(null, null, ['class' => 'form-control', 'placeholder' => 'Component', 'readonly']) }}</div>
              </div>
              <div class="col-lg-2 col-2">
                <div class="form-group"> {{ Form::text(null, null, ['class' => 'form-control', 'placeholder' => 'is equal to', 'readonly']) }}</div>
              </div>
              <div class="col-lg-4 col-4">
                <select class="form-control js-example-tags" name="conditions[{{ $rowCount }}][]" aria-invalid="false">
                  <?php
                  foreach ($componentCategories as $componentKey => $componentCategory) {
                      ?>
                        <option value="{{ $componentKey }}" @if($componentKey==$orCondition) selected @endif>{{ $componentCategory }}</option>
                  <?php
                  }
                  ?>
                </select>
                @if ($errors->has('conditions'))
                  <span class="text-danger">{{ $errors->first('conditions') }}</span>
                @endif
              </div>
              <div class="col-lg-2 col-2">
                <a href="javascript:void(0)" class="btn btn-primary add_form_field" data-andcount="{{ $rowCount }}"> And </a> <a
                   href="javascript:void(0)"
                   class="btn btn-danger delete" data-andcount="{{ $rowCount }}"> - </a>
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
    <a type="javascript:void(0)" class="btn btn-primary rule-group">add rule group</a>
  </div>
  <br>
  <br>
  <div class="form-group">
    {{ Form::label('message_on_disable', 'Message when disable', ['class' => 'control-label required']) }}
    {{ Form::text('message_on_disable', null, ['class' => 'form-control', 'placeholder' => 'Your processor selected is not compatible with this motherboard']) }}
    @if ($errors->has('message_on_disable'))
      <span class="text-danger">{{ $errors->first('message_on_disable') }}</span>
    @endif
  </div>

</div>
<!-- /.card-body -->
