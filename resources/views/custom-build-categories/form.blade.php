<div class="card-body">
  <div class="form-group">
    {{ Form::label('title', 'Custom Build Category Title', ['class' => 'control-label required']) }}
    {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Custom Build Category title']) }}
    @if ($errors->has('title'))
      <span class="text-danger">{{ $errors->first('title') }}</span>
    @endif
  </div>
  <div class="form-group summernotediv">
    {{ Form::label('description', 'Custom Build Category Description', ['class' => 'control-label required']) }}
    {{ Form::textarea('description', null, ['required' => 'required', 'data-msg' => 'Please write Component Category Description', 'class' => 'form-control summernote', 'id' => 'summernote', 'rows' => 10]) }}
    @if ($errors->has('description'))
      <span class="text-danger">{{ $errors->first('description') }}</span>
    @endif
  </div>
  <div class="form-group">
    {{ Form::label('image', 'Custom Build Category Image', ['class' => 'control-label required']) }}
    <div class="input-group">
      <div class="custom-file">
        {{ Form::file('image', null, ['class' => 'custom-file-input', 'id' => 'image']) }}
        <label class="custom-file-label" for="image">Choose file</label>
      </div>
    </div>
    @if ($errors->has('image'))
      <span class="text-danger">{{ $errors->first('image') }}</span>
    @endif
    @if (isset($componentCategory->image) && $componentCategory->image != '')
      <br />
      <img src="{{ asset('/public/img/custom-build-categories/' . $componentCategory->image . '') }}" height='100'>
    @endif
  </div>
  <div class="form-group">
    {{ Form::label('is_active', 'Is Active', ['class' => 'control-label']) }}
    <div class="form-group clearfix">
      <div class="icheck-primary d-inline mr-3">
        <input type="radio" id="radioPrimary1" name="is_active" @if (isset($componentCategory->is_active) && $componentCategory->is_active == 1) checked @endif value="1">
        <label for="radioPrimary1">Yes</label>
      </div>

      <div class="icheck-primary d-inline">
        <input type="radio" id="radioPrimary2" name="is_active" @if (isset($componentCategory->is_active) && $componentCategory->is_active == 0) checked @endif value="0">
        <label for="radioPrimary2">No</label>
      </div>
    </div>
    <span class="js-error"></span>
  </div>
</div>
<!-- /.card-body -->
