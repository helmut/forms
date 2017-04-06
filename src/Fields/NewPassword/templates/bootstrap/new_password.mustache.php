<div class="row">
	<div class="col-sm-12">
		<div class="form-group" style="margin-bottom:10px">
			<label>{{ label }}{{# required }} <span style="font-weight:normal" title="{{ lang.required }}">*</span>{{/ required}}</label>
			<input name="{{ name }}" type="password" value="{{ value }}" placeholder="{{ placeholder }}" class="form-control" style="width:75%">
		</div>
        <div class="form-group" style="margin-bottom:10px">
            <label>Confirm {{ label }}{{# required }} <span style="font-weight:normal" title="{{ lang.required }}">*</span>{{/ required}}</label>
            <input name="{{ name_confirmation }}" type="password" value="{{ value_confirmation }}" placeholder="{{ placeholder }}" class="form-control" style="width:75%">
        </div>
	</div>
</div>
