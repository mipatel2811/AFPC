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
    {{ Form::textarea('description', null, ['required' => 'required', 'data-msg' => 'Please write Component Visibility Description', 'class' => 'form-control summernote', 'id' => 'summernote', 'rows' => 10]) }}
    @if ($errors->has('description'))
      <span class="text-danger">{{ $errors->first('description') }}</span>
    @endif
  </div>

  <div class="add-rowrulegroup"></div>

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
