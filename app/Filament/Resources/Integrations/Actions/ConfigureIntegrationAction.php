<?php

namespace App\Filament\Resources\Integrations\Actions;

use App\Models\Integration;
use App\Models\IntegrationField;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;

class ConfigureIntegrationAction extends Action
{
    public static function getDefaultName(): string
    {
        return 'configure';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Configurar')
            ->icon(Heroicon::Cog6Tooth)
            ->color('gray')
            ->modalHeading('Configurar Campos da Integração')
            ->modalDescription('Defina os campos necessários para configurar esta integração')
            ->modalWidth('4xl')
            ->form([
                Repeater::make('fields')
                    ->label('Campos de Configuração')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome do Campo')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Nome técnico do campo (ex: api_key, username)'),

                        TextInput::make('label')
                            ->label('Rótulo')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Rótulo exibido ao utilizador'),

                        Select::make('type')
                            ->label('Tipo')
                            ->options([
                                'text' => 'Texto',
                                'email' => 'Email',
                                'password' => 'Password',
                                'number' => 'Número',
                                'url' => 'URL',
                                'tel' => 'Telefone',
                                'textarea' => 'Área de Texto',
                                'select' => 'Seleção',
                                'checkbox' => 'Checkbox',
                                'radio' => 'Radio',
                            ])
                            ->required()
                            ->default('text'),

                        TextInput::make('placeholder')
                            ->label('Placeholder')
                            ->maxLength(255),

                        Textarea::make('help_text')
                            ->label('Texto de Ajuda')
                            ->rows(2),

                        Repeater::make('options')
                            ->label('Opções (para select/radio)')
                            ->schema([
                                TextInput::make('value')
                                    ->label('Valor')
                                    ->required(),
                                TextInput::make('label')
                                    ->label('Rótulo')
                                    ->required(),
                            ])
                            ->columns(2)
                            ->visible(fn ($get) => in_array($get('type'), ['select', 'radio'])),

                        TextInput::make('sort_order')
                            ->label('Ordem')
                            ->numeric()
                            ->default(0),

                        Toggle::make('required')
                            ->label('Obrigatório')
                            ->default(false),

                        Toggle::make('is_active')
                            ->label('Ativo')
                            ->default(true),
                    ])
                    ->columns(2)
                    ->defaultItems(0)
                    ->addActionLabel('Adicionar Campo')
                    ->reorderable('sort_order')
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['label'] ?? null),
            ])
            ->fillForm(function (Integration $record): array {
                return [
                    'fields' => $record->fields->map(function (IntegrationField $field) {
                        return [
                            'name' => $field->name,
                            'label' => $field->label,
                            'type' => $field->type,
                            'placeholder' => $field->placeholder,
                            'help_text' => $field->help_text,
                            'options' => $field->options,
                            'sort_order' => $field->sort_order,
                            'required' => $field->required,
                            'is_active' => $field->is_active,
                        ];
                    })->toArray(),
                ];
            })
            ->action(function (Integration $record, array $data): void {
                $record->fields()->delete();

                foreach ($data['fields'] as $fieldData) {
                    IntegrationField::query()->create([
                        'integration_id' => $record->id,
                        'name' => $fieldData['name'],
                        'label' => $fieldData['label'],
                        'type' => $fieldData['type'],
                        'placeholder' => $fieldData['placeholder'],
                        'help_text' => $fieldData['help_text'],
                        'options' => $fieldData['options'] ?? null,
                        'sort_order' => $fieldData['sort_order'],
                        'required' => $fieldData['required'],
                        'is_active' => $fieldData['is_active'],
                    ]);
                }

                Notification::make()
                    ->title('Configuração atualizada com sucesso')
                    ->success()
                    ->send();
            });
    }
}
