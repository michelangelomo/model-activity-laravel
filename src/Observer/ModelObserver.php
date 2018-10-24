<?php
namespace Michelangelo\ModelActivity\Observer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Michelangelo\ModelActivity\Activity;
use Michelangelo\ModelActivity\Models\ModelActivity;

class ModelObserver {

    /**
     * Handle the model "created" event.
     *
     * @param Model $model
     * @return void
     */
    public function created(Model $model) {
        $this->saveRecord($model, Activity::CREATED);
    }

    /**
     * Handle the model "updated" event.
     *
     * @param Model $model
     * @return void
     */
    public function updated(Model $model) {
        $this->saveRecord($model, Activity::UPDATED);
    }

    /**
     * Handle the model "deleted" event.
     *
     * @param Model $model
     * @return void
     */
    public function deleted(Model $model) {
        $this->saveRecord($model, Activity::DELETED);
    }

    /**
     * Handle the model "restored" event.
     *
     * @param Model $model
     * @return void
     */
    public function restored(Model $model) {
        $this->saveRecord($model, Activity::RESTORED);
    }

    /**
     * Handle the model "force deleted" event.
     *
     * @param Model $model
     * @return void
     */
    public function forceDeleted(Model $model) {
        $this->saveRecord($model, Activity::FORCE_DELETED);
    }

    /**
     * Return current user id or null
     *
     * @return null
     */
    private function getCurrentUserId() {
        return (Auth::check()) ? Auth::user()->id : null;
    }

    /**
     * Get difference before and after events
     *
     * @param Model $model
     * @return array
     */
    private function getModelDifferences(Model $model) : string {
        $changes = array();
        foreach($model->getDirty() as $key => $value){
            $original = $model->getOriginal($key);
            $changes[$key] = [
                'old' => $original,
                'new' => $value,
            ];
        }
        return serialize($changes);
    }

    /**
     * @param Model $model
     * @param int $type
     * @return ModelActivity
     */
    private function saveRecord(Model $model, int $type) : ModelActivity {
        $activity = new ModelActivity;
        $activity->model_type = get_class($model);
        $activity->model_id = $model->id;
        (Schema::hasColumn('model_activities', 'user_id')) ? $activity->user_id = $this->getCurrentUserId() : null;
        $activity->differences = $this->getModelDifferences($model);
        $activity->transaction_type = $type;
        $activity->extra = serialize($model->getEventData());
        $activity->save();
        return $activity;
    }
}