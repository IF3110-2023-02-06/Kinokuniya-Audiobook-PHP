<?php

class SettingsView implements ViewInterface
{
    public $data;
    public function __construct($data = []) {
        $this->data = $data;
    }

    public function render() {
        require_once __DIR__ . '/../../components/settings/SettingsPage.php';
    }
}