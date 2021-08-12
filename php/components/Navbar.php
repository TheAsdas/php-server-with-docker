<?php

use php\classes\Component;

class Navbar extends Component
{
    public function __construct()
    {
        
    }

    protected function create(): string
    {
        return <<<HTML
            <div id="">
                <!--- HTML HERE --->
            </div>
        HTML;
    }
}

?>