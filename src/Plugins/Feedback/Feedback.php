<?php 

namespace Helmut\Forms\Plugins\Feedback;

use Helmut\Forms\Plugin;

class Feedback extends Plugin {

	public function onLoad($form)
	{
		$form->addButton('feedback_trigger_'.$form->id);
	}

	public function onSubmitted($form) 
	{
		$request = $form->getRequest();

		if ($request->get('feedback_trigger_'.$form->id)) {

			$field = $form->field($request->get('name'));

			if ( ! is_null($field)) {

				$field->setFromRequest($request);
				$field->runValidations();

				$response = [
					'id' => $field->id, 
					'valid' => $field->valid(), 
					'error_id' => 'feedback_errors_'.$field->id,
					'error' => '', 
				];

				if ( ! $field->valid()) {
					$response['error'] = $form->renderFieldErrors($field);
				}

				header('Content-Type: application/json');
				echo json_encode($response);
				exit();
			}
		}
	}

}