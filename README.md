# Northeastern Support

Package of Blade components for Northeastern University websites

## Prequisites

In order to use this package, your project must be using the [@northeastern-web/kernl-ui JavaScript and CSS package](https://npmjs.com/package/@northeastern-web/kernl-ui).

Your project also must support the new Laravel Blade 7 components.

## Installation

You can install the package via composer:

```bash
composer require northeastern-web/blade-components
```

> Note: You may need to add the following to your `composer.json` file before installing the package.

```json
    "minimum-stability": "dev",
    "prefer-stable": true
```

If your project is using PurgeCss, merge the default PurgeCss content from the `@northeaster-web/kernl-ui` package in your `tailwind.config.js`:

```js
// tailwind.config.js
const defaultConfig = require('@northeastern-web/kernl-ui/defaultConfig');

module.exports = {
    purge: {
        content: [
            ...defaultConfig.purge.content,
            // Your project specific content...
        ],
    },
    // Other stuff...
}
```

## Usage

### Tighten Jigsaw

To use the components in a [tightenco/jigsaw](https://jigsaw.tighten.co), load the `Northeastern\Blade\JigsawServiceProvider` class in the Jigsaw `beforeBuild` event:

```php
// bootstrap.php

use Northeastern\Blade\JigsawServiceProvider;
use TightenCo\Jigsaw\Jigsaw;

$events->beforeBuild(function (Jigsaw $jigsaw) {
    (new JigsawServiceProvider($jigsaw->app))->boot();
});
```

## Components

### Local Header

To use the local header component, add the following markup to your Blade template.

```blade
<x-kernl-local-header :links="$links" :current-path="$currentPath">
    <x-slot name="logo">
        <!-- Insert SVG logo here with class="w-full" applied -->
    </x-slot>
    <x-slot name="searchModal">
        <!-- If you have a search modal implemented, add the markup/component here. Otherwise omit this slot. -->
    </x-slot>
</x-kernl-local-header>
```

#### Props

- `links` = Array of links for the navigation sections of the header. Each link can have a `children` key that's an array of more links. These links will be displayed in a dropdown under the parent link. Example:
    ```php
    $links = [
        [
            'text' => 'Our Programs',
            'href' => '/programs',
        ],
        [
            'text' => 'About',
            'href' => '/about',
            'children' => [
                [
                    'text' => 'Careers',
                    'href' => '/about/careers',
                ],
                [
                    'text' => 'Staff',
                    'href' => '/about/staff',
                ],
            ],
        ],
    ];
    ```
- `current-path` - Used to display the active state on each link. Pass the relative path of the current page (`/about/staff`).

### Accordions

To use the accordion component, add the following markup to your Blade template.

```blade
<x-kernl-accordion.base label="Leadership roles accordion" default-section="accordion-item-1">
    <x-kernl-accordion.item title="Accordion Item 1 Title" id="accordion-item-2">
        Accordion Item 1 Content
    </x-kernl-accordion.item>
    <x-kernl-accordion.item title="Accordion Item 2 Title" id="accordion-item-2">
        Accordion Item 2 Content
    </x-kernl-accordion.item>
</x-kernl-accordion.base>
```

Alertnatively, you can use the `x-kernl-accordion.with-left-icon` component for a slightly different design.

```blade
<x-kernl-accordion.base label="Leadership roles accordion" default-section="accordion-item-1">
    <x-kernl-accordion.with-left-icon title="Accordion Item 1 Title" id="accordion-item-2">
        Accordion Item 1 Content
    </x-kernl-accordion.with-left-icon>
    <x-kernl-accordion.item title="Accordion Item 2 Title" id="accordion-item-2">
        Accordion Item 2 Content
    </x-kernl-accordion.item>
</x-kernl-accordion.base>
```

#### `x-kernl-accordion.base` Props

- `label` = The aria-label for the accordion `ul` element
- `default-section` (optional) = The `id` of the accordion item that should be open by default

#### `x-kernl-accordion.item`/`x-kernl-accordion.with-left-icon` Props

- `title` - The title that should be shown on the accordion button
- `id` (optional) - The ID that should be assigned to the accordion. This should match the `default-section` prop passed to the base accordion component for the accordion item that should be open by default.
