<div class="row">
	<div class="col-sm-12">
		<div class="form-group" style="margin-bottom:0">
			<label class="control-label">{{ label }}{{# required }} <span style="font-weight:normal" title="{{ lang.required }}">*</span>{{/ required}}</label>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group" style="margin-bottom:10px">
			<input name="{{ name_first }}" value="{{ value_first }}" type="text" placeholder="{{ lang.placeholder_first }}" class="form-control">
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group" style="margin-bottom:10px">			
			<input name="{{ name_surname }}" value="{{ value_surname }}" type="text" placeholder="{{ lang.placeholder_surname }}" class="form-control">
		</div>
	</div>
</div>
