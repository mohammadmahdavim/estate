<?php

namespace App\View\Components;

use Illuminate\View\Component;


class destroy extends Component
{

    public $id;
    public $url;
    public function __construct($id,$url)
    {
        $this->id = $id;
        $this->url = $url;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        return view('components.destroy');
    }
}
