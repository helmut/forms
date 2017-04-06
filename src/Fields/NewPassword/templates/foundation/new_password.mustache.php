<div class="row">
	<div class="medium-12 columns">
		<label>{{ label }}{{# required }} <span style="font-weight:normal" title="{{ lang.required }}">*</span>{{/ required}}
			<input name="{{ name }}" type="password" value="{{ value }}" style="width:75%">
		</label>
        <label>{{ lang.confirm }} {{ label }}{{# required }} <span style="font-weight:normal" title="{{ lang.required }}">*</span>{{/ required}}
            <input name="{{ name_confirmation }}" type="password" value="{{ value_confirmation }}" style="width:75%">
        </label>         
	</div>
</div>
