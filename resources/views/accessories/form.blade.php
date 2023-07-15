<div class="card-body">
  <div class="form-group">
    {{ Form::label('title', 'Title', ['class' => 'control-label required']) }}
    {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Accessory title']) }}
    @if ($errors->has('title'))
      <span class="text-danger">{{ $errors->first('title') }}</span>
    @endif
  </div>
  <div class="form-group summernotediv">
    {{ Form::label('description', 'Accessory Description', ['class' => 'control-label required']) }}
    {{ Form::textarea('description', null, ['required' => 'required', 'data-msg' => 'Please write Accessories Description', 'class' => 'form-control summernote', 'id' => 'summernote', 'rows' => 10]) }}
    @if ($errors->has('description'))
      <span class="text-danger">{{ $errors->first('description') }}</span>
    @endif
  </div>
  <div class="row">
    <div class="col-lg-12 col-12">
      <div class="form-group">
        {{ Form::label('category_id', 'Accessory category', ['class' => 'control-label required']) }}
        @if (isset($accessory) && $accessory->category_id != null)
          {{ Form::select('category_id', $accessoriesCategories, $accessory->category_id, ['class' => 'form-control js-example-tags']) }}
        @else
          {{ Form::select('category_id', $accessoriesCategories, null, ['class' => 'form-control js-example-tags']) }}
        @endif
        @if ($errors->has('category_id'))
          <span class="text-danger">{{ $errors->first('category_id') }}</span>
        @endif
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-4 col-6">
      <div class="form-group">
        {{ Form::label('regular_price', 'Regular Price', ['class' => 'control-label required']) }}
        {{ Form::text('regular_price', null, ['class' => 'form-control', 'placeholder' => 'Accessory Regular Price']) }}
        @if ($errors->has('regular_price'))
          <span class="text-danger">{{ $errors->first('regular_price') }}</span>
        @endif
      </div>
    </div>
    <div class="col-lg-4 col-6">
      <div class="form-group">
        {{ Form::label('special_price', 'Special Price', ['class' => 'control-label']) }}
        {{ Form::text('special_price', null, ['class' => 'form-control', 'placeholder' => 'Accessory Special Price']) }}
        @if ($errors->has('special_price'))
          <span class="text-danger">{{ $errors->first('special_price') }}</span>
        @endif
      </div>
    </div>
    <div class="col-lg-4 col-6">
      <div class="form-group">
        {{ Form::label('sku', 'SKU', ['class' => 'control-label']) }}
        {{ Form::text('sku', null, ['class' => 'form-control', 'placeholder' => 'Accessory SKU']) }}
        @if ($errors->has('sku'))
          <span class="text-danger">{{ $errors->first('sku') }}</span>
        @endif
      </div>
    </div>
  </div>
  <div class="form-group">
    {{ Form::label('image', 'Image', ['class' => 'control-label required']) }}
    <div class="input-group">
      <div class="custom-file">
        {{ Form::file('image', null, ['class' => 'custom-file-input', 'id' => 'image']) }}
        <label class="custom-file-label" for="image">Choose file</label>
      </div>
    </div>
    @if ($errors->has('image'))
      <span class="text-danger">{{ $errors->first('image') }}</span>
    @endif
    @if (isset($accessory->image) && $accessory->image != '')
      <br />
      <img src="{{ asset('/public/img/accessories/' . $accessory->image . '') }}" height='100'>
    @endif
  </div>
  <div class="form-group">
    {{ Form::label('stock', 'Stock', ['class' => 'control-label required']) }}
    {{ Form::text('stock', null, ['class' => 'form-control', 'placeholder' => 'Stock']) }}
    @if ($errors->has('stock'))
      <span class="text-danger">{{ $errors->first('stock') }}</span>
    @endif
  </div>
  <div class="form-group">
    {{ Form::label('is_active', 'Is Active', ['class' => 'control-label']) }}
    <div class="form-group clearfix">
      <div class="icheck-primary d-inline mr-3">
        <input type="radio" id="radioPrimary1" name="is_active" @if (isset($accessory->is_active) && $accessory->is_active == 1) checked @endif value="1">
        <label for="radioPrimary1">Yes</label>
      </div>
      <div class="icheck-primary d-inline">
        <input type="radio" id="radioPrimary2" name="is_active" @if (isset($accessory->is_active) && $accessory->is_active == 0) checked @endif value="0">
        <label for="radioPrimary2">No</label>
      </div>
    </div>
    <span class="js-error"></span>
  </div>
</div>
<!-- /.card-body -->
