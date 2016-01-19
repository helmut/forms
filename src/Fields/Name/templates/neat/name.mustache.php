<div>
	<label>{{ label }}{{# required }} <span style="font-weight:normal" title="{{ lang.required }}">*</span>{{/ required}}</label><br />
	<div class="col-half" style="margin-bottom:10px">
		<input name="{{ name_first }}" value="{{ value_first }}" type="text" placeholder="{{ lang.placeholder_first }}" style="width:100%">
	</div>
	<div class="col-half" style="margin-bottom:10px">
		<input name="{{ name_surname }}" value="{{ value_surname }}" type="text" placeholder="{{ lang.placeholder_surname }}" style="width:100%">
	</div>
</div>
