<?php
namespace Northeastern\Blade\Components\Cards;

use Exception;
use Illuminate\Support\Facades\View;
use Illuminate\View\Component;

class Event extends Component
{
    public $imageUrl;
    public $title;
    public $body;
    public $color;
    public $url;
    public $orientation;
    public $withFooter;
    public $footerText;
    public $aspectRatio;
    public $date;
    public $time;

    public function __construct(
        $title,
        $body,
        $imageUrl,
        $url = '#',
        $color = 'light',
        $orientation = 'vertical',
        $withFooter = false,
        $footerText = '',
        $aspectRatio = '16:9',
        $date = null,
        $time = null
    ) {
        $this->imageUrl = $imageUrl;
        $this->title = $title;
        $this->body = $body;
        $this->color = $color;
        $this->url = $url;
        $this->orientation = $orientation;
        $this->withFooter = $withFooter;
        $this->footerText = $footerText;
        $this->aspectRatio = $aspectRatio;
        $this->date = $date;
        $this->time = $time;

        if (! collect(['light', 'light-gray', 'dark'])->contains($this->color)) {
            throw new Exception('Provided color is not supported');
        }
    }

    public function cardClasses()
    {
        return collect()
            ->merge([
                'shadow-sm',
                'transition-colors',
                'group',
                'focus:outline-none',
                'focus:ring',
                'focus:ring-blue-500',
            ])
            ->merge([
                $this->attributes->first('class'),
            ])
            // Color
            ->when($this->color === 'light', function ($classes) {
                return $classes->push('bg-white', 'hover:bg-gray-100', 'text-gray-900');
            })
            ->when($this->color === 'light-gray', function ($classes) {
                return $classes->push('bg-gray-200', 'hover:bg-gray-300', 'text-gray-900');
            })
            ->when($this->color === 'dark', function ($classes) {
                return $classes->push('bg-black', 'hover:bg-gray-800', 'text-white');
            })
            // Orientation
            ->when($this->orientation === 'vertical', function ($classes) {
                return $classes->push('flex', 'flex-col');
            })
            ->when($this->orientation === 'horizontal', function ($classes) {
                return $classes->push('flex', 'flex-col', 'lg:flex-row');
            })
            ->when($this->orientation === 'horizontal-flipped', function ($classes) {
                return $classes->push('flex', 'flex-col', 'lg:flex-row-reverse');
            })
            ->join(' ')
            ;
    }

    public function titleClasses()
    {
        return collect()
            ->merge([
                'text-lg',
                'font-bold',
            ])
            ->when($this->color === 'dark', function ($classes) {
                return $classes->merge([
                    'text-white',
                ]);
            })
            ->when($this->color !== 'dark', function ($classes) {
                return $classes->merge([
                    'text-gray-900',
                ]);
            })
            ->join(' ')
            ;
    }

    public function bodyClasses()
    {
        return collect()
            ->merge([
                'mt-2',
                'text-sm',
            ])
            ->when($this->color === 'dark', function ($classes) {
                return $classes->merge([
                    'text-gray-300',
                ]);
            })
            ->when($this->color !== 'dark', function ($classes) {
                return $classes->merge([
                    'text-gray-700',
                ]);
            })
            ->join(' ')
            ;
    }

    public function eventClasses()
    {
        return collect()
            ->merge([
                'space-y-2',
            ])
            ->when($this->color === 'dark', function ($classes) {
                return $classes->push('text-white');
            })
            ->when($this->color !== 'dark', function ($classes) {
                return $classes->push('text-gray-900');
            })
            ->join(' ');
    }

    public function imageOuterImageContainerClasses()
    {
        return collect()
            ->merge([
                'relative',
                'w-full',
                'bg-black',
            ])
            ->when($this->orientation !== 'vertical', function ($classes) {
                return $classes->push('flex-shrink-0', 'lg:w-72');
            })
            ->join(' ')
        ;
    }

    public function imageInnerImageContainerClasses()
    {
        return collect()
            ->merge([
                'h-full',
            ])
            ->when($this->aspectRatio === '1:1', function ($classes) {
                return $classes->push('aspect-w-1', 'aspect-h-1');
            })
            ->when($this->aspectRatio === '3:1', function ($classes) {
                return $classes->push('aspect-w-3', 'aspect-h-1');
            })
            ->when($this->aspectRatio === '3:4', function ($classes) {
                return $classes->push('aspect-w-3', 'aspect-h-4');
            })
            ->when($this->aspectRatio === '4:3', function ($classes) {
                return $classes->push('aspect-w-4', 'aspect-h-3');
            })
            ->when($this->aspectRatio === '4:5', function ($classes) {
                return $classes->push('aspect-w-4', 'aspect-h-5');
            })
            ->when($this->aspectRatio === '5:4', function ($classes) {
                return $classes->push('aspect-w-5', 'aspect-h-4');
            })
            ->when($this->aspectRatio === '16:9', function ($classes) {
                return $classes->push('aspect-w-16', 'aspect-h-9');
            })
            ->join(' ');
    }

    public function footerClasses()
    {
        return collect()
            ->merge([
                'flex',
                'items-center',
                'justify-between',
                'mt-10',
            ])
            ->when($this->color === 'dark', function ($classes) {
                return $classes->merge([
                    'text-gray-300',
                ]);
            })
            ->when($this->color !== 'dark', function ($classes) {
                return $classes->merge([
                    'text-gray-700',
                ]);
            })
            ->join(' ')
            ;
    }

    public function footerTextClasses()
    {
        return collect()
            ->merge([
                'text-sm',
            ])
            ->join(' ')
            ;
    }

    public function render()
    {
        return View::make('kernl-ui::cards.event');
    }
}
