<?php

use Livewire\Component;

new class extends Component
{
    public $greetings='Hello Dude';
};
?>

<div>
    {{$greetings}}
</div>