@php
$rowCount = 0;
@endphp
@foreach (json_decode($visibility_data->conditions, true) as $key => $condtions)
  <div class="add-row_{{ $rowCount }}">
    @if ($rowCount > 0)
      <div class="form-group"><label for="select_condition_to_display" class="control-label required">Or</label></div>
    @endif
    @foreach ($condtions as $innerKey => $condtion)
      <div class="form-group condition-row"><label for="select_condition_to_display" class="control-label required">Select Condition to
          display</label>
        <div class="row">
          <div class="col-lg-4 col-4">
            <div class="form-group"> <input class="form-control" placeholder="Component" readonly="" type="text"></div>
          </div>
          <div class="col-lg-2 col-2">
            <div class="form-group"> <input class="form-control" placeholder="is equal to" readonly="" type="text"></div>
          </div>
          <div class="col-lg-4 col-4"> <select class="form-control js-example-tags"
                    name="customBuild[{{ $cat_id }}][2][conditions][{{ $rowCount }}][]" aria-invalid="false">
              @foreach ($components as $optionKey => $optionValue)
                <option value="{{ $optionKey }}" @if ($optionKey == $condtion) selected @endif>
                  {{ $optionValue }}</option>
              @endforeach
            </select></div>
          <div class="col-lg-2 col-2">
            <a href="javascript:void(0)" class="btn btn-primary add_form_field" data-andcount="{{ $rowCount }}"
               onclick="addRow('{{ $rowCount }}','{{ $cat_id }}','{{ $id }}')"> And </a>
            <a href="javascript:void(0)"
               class="btn btn-danger delete" data-andcount="{{ $rowCount }}"
               onclick="deleteRow('{{ $rowCount }}','{{ $id }}')"> - </a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  @php
    $rowCount++;
  @endphp
@endforeach
