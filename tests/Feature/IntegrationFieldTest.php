<?php

namespace Tests\Feature;

use App\Models\Integration;
use App\Models\IntegrationCategory;
use App\Models\IntegrationField;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IntegrationFieldTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_integration_field(): void
    {
        $user = User::factory()->create();
        $category = IntegrationCategory::factory()->create();
        $integration = Integration::factory()->create(['integration_category_id' => $category->id]);

        $fieldData = [
            'integration_id' => $integration->id,
            'name' => 'api_key',
            'label' => 'Chave da API',
            'type' => 'password',
            'required' => true,
            'placeholder' => 'Digite sua chave da API',
            'help_text' => 'Esta chave é necessária para autenticação',
            'sort_order' => 1,
            'is_active' => true,
        ];

        $field = IntegrationField::query()->create($fieldData);

        $this->assertDatabaseHas('integration_fields', [
            'integration_id' => $integration->id,
            'name' => 'api_key',
            'label' => 'Chave da API',
            'type' => 'password',
            'required' => true,
        ]);

        $this->assertEquals($integration->id, $field->integration_id);
        $this->assertEquals('api_key', $field->name);
        $this->assertEquals('Chave da API', $field->label);
    }

    public function test_integration_has_fields_relationship(): void
    {
        $category = IntegrationCategory::factory()->create();
        $integration = Integration::factory()->create(['integration_category_id' => $category->id]);

        IntegrationField::factory()->create([
            'integration_id' => $integration->id,
            'name' => 'field1',
            'label' => 'Campo 1',
        ]);

        IntegrationField::factory()->create([
            'integration_id' => $integration->id,
            'name' => 'field2',
            'label' => 'Campo 2',
        ]);

        $this->assertCount(2, $integration->fields);
        $this->assertEquals('field1', $integration->fields->first()->name);
        $this->assertEquals('field2', $integration->fields->last()->name);
    }

    public function test_fields_are_ordered_by_sort_order(): void
    {
        $category = IntegrationCategory::factory()->create();
        $integration = Integration::factory()->create(['integration_category_id' => $category->id]);

        IntegrationField::factory()->create([
            'integration_id' => $integration->id,
            'name' => 'third',
            'sort_order' => 3,
        ]);

        IntegrationField::factory()->create([
            'integration_id' => $integration->id,
            'name' => 'first',
            'sort_order' => 1,
        ]);

        IntegrationField::factory()->create([
            'integration_id' => $integration->id,
            'name' => 'second',
            'sort_order' => 2,
        ]);

        $fields = $integration->fields;

        $this->assertEquals('first', $fields[0]->name);
        $this->assertEquals('second', $fields[1]->name);
        $this->assertEquals('third', $fields[2]->name);
    }

    public function test_can_create_field_with_options(): void
    {
        $category = IntegrationCategory::factory()->create();
        $integration = Integration::factory()->create(['integration_category_id' => $category->id]);

        $options = [
            ['value' => 'option1', 'label' => 'Opção 1'],
            ['value' => 'option2', 'label' => 'Opção 2'],
        ];

        $field = IntegrationField::query()->create([
            'integration_id' => $integration->id,
            'name' => 'country',
            'label' => 'País',
            'type' => 'select',
            'options' => $options,
            'required' => true,
        ]);

        $this->assertEquals($options, $field->options);
        $this->assertIsArray($field->options);
    }
}
