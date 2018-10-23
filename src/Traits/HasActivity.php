<?php
namespace Michelangelo\ModelActivity\Traits;

trait HasActivity {

    public function activities() {
        return $this->morphMany(\Michelangelo\ModelActivity\Models\ModelActivity::class, 'model');
    }

}