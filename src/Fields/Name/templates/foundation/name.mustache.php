<div class="row">
	<div class="medium-12 columns">
		<label class="control-label">{{ label }}{{# required }} <span style="font-weight:normal" title="{{ lang.required }}">*</span>{{/ required}}</label>
	</div>
	<div class="medium-6 columns">
		<input name="{{ name_first }}" value="{{ value_first }}" type="text" placeholder="{{ lang.placeholder_first }}">
	</div>
	<div class="medium-6 columns">
		<input name="{{ name_surname }}" value="{{ value_surname }}" type="text" placeholder="{{ lang.placeholder_surname }}">
	</div>
</div>
