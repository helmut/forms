<?php

namespace Helmut\Forms\Testing;

class TextTest extends FormTestCase {

    /** @test */
    public function it_can_be_rendered()
    {
        $form = $this->form();
        $form->text('foo');
        $this->assertContains('<input name="foo" value=""', $form->render());
    }

    /** @test */
    public function it_can_set_a_width()
    {
        $form = $this->form();
        $form->text('foo')->width('75%');
        $this->assertContains('width:75%', $form->render());
    }

    /** @test */
    public function it_renders_a_default_value()
    {
        $form = $this->form();
        $form->text('foo')->default('bar');
        $this->assertContains('<input name="foo" value="bar"', $form->render());
    }

    /** @test */
    public function it_renders_model_values()
    {
        $form = $this->form();
        $form->defaults($this->model(['foo'=>'bar']));
        $form->text('foo');
        $this->assertContains('<input name="foo" value="bar"', $form->render());
    }

    /** @test */
    public function it_can_fill_model_values()
    {
        $model = $this->model(['foo'=>'']);

        $form = $this->form();
        $form->text('foo')->default('bar');
        $form->fill($model);

        $form->assertEquals($model->foo, 'bar');
    }

    /** @test */
    public function it_escapes_value()
    {
        $form = $this->form();
        $form->text('foo')->default('bar&');
        $this->assertContains('<input name="foo" value="bar&amp;"', $form->render());
    }   

    /** @test */
    public function it_provides_expected_values()
    {
        $form = $this->form();
        $form->text('foo');

        $this->assertSame($form->get('foo'), '');
    }   

    /** @test */
    public function it_provides_expected_default_values()
    {
        $form = $this->form();
        $form->text('foo')->default('bar');

        $this->assertSame($form->get('foo'), 'bar');
    }

    /** @test */
    public function it_validates_required()
    {
        $this->assertValid(function($form) { $form->text('foo'); });

        $this->assertNotValid(function($form) { $form->text('foo')->required(); });
    }

    /** @test */
    public function it_validates_between()
    {
        $this->assertValid(function($form) { $form->text('foo')->between(5, 7); });
        $this->assertValid(function($form) { $form->text('foo')->between(5, 7)->default('123456'); });

        $this->assertNotValid(function($form) { $form->text('foo')->between(5, 7)->required(); });
        $this->assertNotValid(function($form) { $form->text('foo')->between(5, 7)->default('123'); });
        $this->assertNotValid(function($form) { $form->text('foo')->between(5, 7)->default('123456789'); });
    }

    /** @test */
    public function it_validates_min()
    {
        $this->assertValid(function($form) { $form->text('foo')->min(5); });
        $this->assertValid(function($form) { $form->text('foo')->min(5)->default('123456789'); });

        $this->assertNotValid(function($form) { $form->text('foo')->min(5)->required(); });
        $this->assertNotValid(function($form) { $form->text('foo')->min(5)->default('123'); });
    }   

    /** @test */
    public function it_validates_max()
    {
        $this->assertValid(function($form) { $form->text('foo')->max(5); });
        $this->assertValid(function($form) { $form->text('foo')->max(5)->default('123'); });

        $this->assertNotValid(function($form) { $form->text('foo')->max(5)->required(); });
        $this->assertNotValid(function($form) { $form->text('foo')->max(5)->default('123456789'); });
    }

    /** @test */
    public function it_validates_alpha()
    {
        $this->assertValid(function($form) { $form->text('foo')->alpha(); });
        $this->assertValid(function($form) { $form->text('foo')->alpha()->default('valid'); });

        $this->assertNotValid(function($form) { $form->text('foo')->alpha()->required(); });
        $this->assertNotValid(function($form) { $form->text('foo')->alpha()->default('inv@lid'); });
        $this->assertNotValid(function($form) { $form->text('foo')->alpha()->default('123456'); });
        $this->assertNotValid(function($form) { $form->text('foo')->alpha()->default('abc123'); });
    }

    /** @test */
    public function it_validates_alpha_num()
    {
        $this->assertValid(function($form) { $form->text('foo')->alpha_num(); });
        $this->assertValid(function($form) { $form->text('foo')->alpha_num()->default('valid'); });
        $this->assertValid(function($form) { $form->text('foo')->alpha_num()->default('valid123'); });
        $this->assertValid(function($form) { $form->text('foo')->alpha_num()->default('123'); });

        $this->assertNotValid(function($form) { $form->text('foo')->alpha_num()->required(); });
        $this->assertNotValid(function($form) { $form->text('foo')->alpha_num()->default('valid 123'); });
        $this->assertNotValid(function($form) { $form->text('foo')->alpha_num()->default('valid_123'); });
        $this->assertNotValid(function($form) { $form->text('foo')->alpha_num()->default('inv@lid123'); });
    }   

    /** @test */
    public function it_validates_alpha_dash()
    {
        $this->assertValid(function($form) { $form->text('foo')->alpha_dash(); });
        $this->assertValid(function($form) { $form->text('foo')->alpha_dash()->default('valid'); });
        $this->assertValid(function($form) { $form->text('foo')->alpha_dash()->default('valid123'); });
        $this->assertValid(function($form) { $form->text('foo')->alpha_dash()->default('valid-123'); });
        $this->assertValid(function($form) { $form->text('foo')->alpha_dash()->default('valid_123'); });
        $this->assertValid(function($form) { $form->text('foo')->alpha_dash()->default('123'); });

        $this->assertNotValid(function($form) { $form->text('foo')->alpha_dash()->required(); });
        $this->assertNotValid(function($form) { $form->text('foo')->alpha_dash()->default('valid 123'); });
        $this->assertNotValid(function($form) { $form->text('foo')->alpha_dash()->default('inv@lid123'); });
    }

    /** @test */
    public function it_validates_in()
    {
        $this->assertValid(function($form) { $form->text('foo')->in(); });
        $this->assertValid(function($form) { $form->text('foo')->in(['a', 'b','c']); });
        $this->assertValid(function($form) { $form->text('foo')->in(['a', 'b','c'])->default('a'); });

        $this->assertNotValid(function($form) { $form->text('foo')->in(['a', 'b','c'])->required(); });
        $this->assertNotValid(function($form) { $form->text('foo')->in(['a', 'b','c'])->default('d'); });
    }

    /** @test */
    public function it_validates_not_in()
    {
        $this->assertValid(function($form) { $form->text('foo')->not_in(); });
        $this->assertValid(function($form) { $form->text('foo')->not_in(['a', 'b','c']); });
        $this->assertValid(function($form) { $form->text('foo')->not_in(['a', 'b','c'])->default('d'); });

        $this->assertNotValid(function($form) { $form->text('foo')->not_in(['a', 'b','c'])->required(); });
        $this->assertNotValid(function($form) { $form->text('foo')->not_in(['a', 'b','c'])->default('a'); });
    }   

}
