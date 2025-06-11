<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\License;

use Illuminate\Support\Str;
use MoonShine\ChangeLog\Components\ChangeLog;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\Layer;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Flex;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends ModelResource<License>
 */
class LicenseResource extends ModelResource
{
    protected string $model = License::class;

    protected string $title = 'Лицензии';
    protected bool $createInModal = true;
    protected string $column = 'name';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            Text::make('Наименование', 'name'),
            Date::make('Истекает','expires_at')->format('d.m.Y'),
            HasMany::make('Привязанные устройства', 'devices')->relatedLink(),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                Text::make('Ключ', 'key')->readonly()->eye()->copy()->setValue($this->generateUniqueKey()),
                Flex::make([
                    Number::make('Количество устройств','count_device')->default(1)->min(1),
                    Date::make('Истекает', 'expires_at')->required(),
                ]),
                Text::make('Наименование', 'name')->required(),
                Textarea::make('Описание', 'description'),
                HasMany::make('Привязанные устройства', 'devices'),
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            Text::make('Ключ', 'key')->readonly()->eye()->copy()->setValue($this->generateUniqueKey()),
            Number::make('Количество устройств','count_device')->default(1)->min(1),
            Date::make('Истекает', 'expires_at')->required()->format('d.m.Y'),
            Text::make('Наименование', 'name')->required(),
            Textarea::make('Описание', 'description'),
            HasMany::make('Привязанные устройства', 'devices'),
        ];
    }

    /**
     * @param License $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
    protected function onBoot(): void
    {
        $this->getPages()
            ->detailPage()
            ->pushToLayer(
                Layer::BOTTOM,
                ChangeLog::make('История изменений', $this, \App\MoonShine\Resources\MoonShineUserResource::class)
            );
    }
    private function generateUniqueKey(): string
    {
        do {
            $key = Str::random(32); // Генерация случайного ключа длиной 32 символа
        } while (License::where('key', $key)->exists()); // Проверка на уникальность

        return $key;
    }

    public function search(): array
    {
        return ['key', 'name'];
    }
}
