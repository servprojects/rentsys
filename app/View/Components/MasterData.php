<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MasterData extends Component
{
    /**
     * Create a new component instance.
     */
   
     public $dataTitle;
     public $createRoute;
     public $headerItems;
     public $loadingSpan;
 
     public function __construct($dataTitle, $createRoute, $headerItems, $loadingSpan)
     {
         $this->dataTitle = $dataTitle;
         $this->createRoute = $createRoute;
         $this->headerItems = $headerItems;
         $this->loadingSpan = $loadingSpan;
     }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.master-data');
    }
}
