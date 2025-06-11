<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use MoonShine\Laravel\Enums\Ability;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Laravel\Components\Layout\{Locales, Notifications, Profile, Search};
use MoonShine\UI\Components\{Breadcrumbs,
    Components,
    Layout\Flash,
    Layout\Div,
    Layout\Body,
    Layout\Burger,
    Layout\Content,
    Layout\Footer,
    Layout\Head,
    Layout\Favicon,
    Layout\Assets,
    Layout\Meta,
    Layout\Header,
    Layout\Html,
    Layout\Layout,
    Layout\Logo,
    Layout\Menu,
    Layout\Sidebar,
    Layout\ThemeSwitcher,
    Layout\TopBar,
    Layout\Wrapper,
    When};
use MoonShine\MenuManager\MenuItem;
use App\MoonShine\Resources\LicenseResource;
use App\MoonShine\Resources\DeviceResource;

final class MoonShineLayout extends AppLayout
{
    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function menu(): array
    {
        return [
            ...parent::menu(),
            MenuItem::make('Лицензии', LicenseResource::class)->canSee(fn () => auth()->user()->isHavePermission(LicenseResource::class, Ability::VIEW)),
            MenuItem::make('Устройства', DeviceResource::class)->canSee(fn () => auth()->user()->isHavePermission(DeviceResource::class, Ability::VIEW)),
        ];
    }

    /**
     * @param ColorManager $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        // $colorManager->primary('#00000');
    }

    public function build(): Layout
    {
        return parent::build();
    }
    protected function getFooterComponent(): Footer
    {
        return Footer::make([]); // Возвращаем пустой footer
    }
    protected function getFaviconComponent(): Favicon
    {
        return Favicon::make()->customAssets([
            'apple-touch' => asset('mini-logo.svg'),
            '32' => asset('mini-logo.svg'),
            '16' => asset('mini-logo.svg'),
            'safari-pinned-tab' => asset('mini-logo.svg'),
            'web-manifest' => asset('mini-logo.svg'),
        ]);
    }
}
