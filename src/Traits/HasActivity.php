<?php
namespace Michelangelo\ModelActivity\Traits;

use Michelangelo\ModelActivity\Activity;
use Michelangelo\ModelActivity\Models\ModelActivity;

trait HasActivity {


    /**
     * Return relationship with model
     * @return mixed
     */
    public function activities() {
        return $this->morphMany(ModelActivity::class, 'model');
    }

    /**
     * Filter by transaction type
     * @param int $type
     * @return null
     */
    public function getFromType(int $type){
        if(!Activity::inStatus($type)) return null;

        return ModelActivity::where('transaction_type', $type)
            ->where('model_type', get_class($this))
            ->where('model_id', $this->id())
            ->get();
    }

    public $eventData = [];

    /**
     * Get the event data by event
     *
     * @return array|NULL
     */
    public function getEventData() : array {
        return $this->eventData;
    }

    /**
     * @param array $eventData
     */
    public function setEventData(array $eventData) : void {
        $this->eventData = $eventData;
    }

}