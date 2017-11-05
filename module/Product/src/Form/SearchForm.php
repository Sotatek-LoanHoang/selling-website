<?php
namespace Product\Form;

use Zend\Form\Form;

class SearchForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('search');
        $this->add([
            'name' => 'q',
            'type' => 'text',
            'attributes' => [
              'placeholder' => 'Search here...',
            ]
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Search',
                'id'    => 'submitbutton',
            ],
        ]);
        $this->setAttribute('method', 'GET');
    }
}
