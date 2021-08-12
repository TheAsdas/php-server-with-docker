<?php

namespace php\classes;

use mysqli;
use mysqli_result;

/**
 * # Component
 * An HTML component that can be reused in various parts of your code.
 * 
 * Any component you wish to create for your project shall extend this class.
 * Whenever you want to add your component to any of your pages, you do it by
 * using `<?= new MyComponent() ?>` or by storing it in a variable and echoing
 * it into your document.  
 * It's important to not override the `__toString()` method, since it's the one
 * that prints the HTML string into your page.
 */
abstract class Component
{
    protected string $html;

    /**
     * This method shall always call the `$this->create()` method when invoked.
     * 
     * If you need your component to receive extra parameters before its creation,
     * you can override this method, but don't forget to call the creator method,
     * either by `$this->html = $this->create()` or `parent::__construct()` after
     * doing your logic. 
     */
    public function __construct()
    {
        $this->html = $this->create();
    }

    /**
     * # Create the HTML Element
     * This function creates the HTML structure of your component, through a string.
     *
     * Feel free to add any logic before creating said structure, but never forget to 
     * return it. I recommend using the __heredoc__ syntax for easier writing and 
     * Intellisense support. Example of use with heredoc:  
     * ```php
     * return <<<HTML
     * <div>
     *    <!-- Your HTML structure here --->
     * </div>
     * HTML;
     * ```
     * 
     * @return string HTML Structure.
     */
    protected abstract function create(): string;

    public function __toString()
    {
        return $this->html;
    }
}
