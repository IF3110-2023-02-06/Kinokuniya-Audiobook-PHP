<?php

class BookPreviewView implements ViewInterface
{
    public $data;
    public function __construct($data = []) {
        $this->data = $data;
    }

    public function render() {
        require_once __DIR__ . '/../../components/catalogue/BookPreviewPage.php';
    }
}