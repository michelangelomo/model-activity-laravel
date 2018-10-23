<?php

namespace Michelangelo\ModelActivity\Models;

use Illuminate\Database\Eloquent\Model;

class ModelActivity extends Model {

    protected $table = 'model_activities';

    protected $fillable = ['model_type', 'model_id', 'transaction_type', 'data', 'user_id'];

    public function user() {
        return $this->morphTo();
    }

    public function differences() : array {
        return unserialize($this->differences);
    }
}