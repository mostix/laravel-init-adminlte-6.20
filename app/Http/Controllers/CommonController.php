<?php

namespace App\Http\Controllers;

class CommonController extends Controller
{

    /**
     * @params entityId required
     *         model required
     *         booleanType required (Ex: active, status)
     *         status required
     * Toggle Model's active database field
     */
    public function toggleBoolean()
    {
        if (!request()->filled('entityId') || !request()->filled('model') || !request()->filled('booleanType') || !request()->filled('status')) {
            return back();
        }
        $entityId = request()->get('entityId');
        $booleanType = request()->get('booleanType');
        $model = "\App\Models\\".request()->get('model');
        if (!class_exists($model)) {
            $model = "\App\\".request()->get('model');
            if (!class_exists($model)) {
                return back();
            }
        }
        $status = request()->get('status');

        $entity = $model::find($entityId);
        $entity->$booleanType = $status;
        $entity->save();
    }

    public function togglePermissions()
    {
        if (!request()->filled('entityId') || !request()->filled('model') || !request()->filled('permission') || !request()->filled('status')) {
            return back();
        }
        $entityId = request()->get('entityId');
        $permission = request()->get('permission');
        $model = "\App\Models\\".request()->get('model');
        if (!class_exists($model)) {
            $model = "\App\\".request()->get('model');
            if (!class_exists($model)) {
                return back();
            }
        }
        $status = request()->get('status');
        $entity = $model::find($entityId);

        if ($status == 0) {
            $entity->revokePermissionTo($permission);
        }
        else {
            $entity->givePermissionTo($permission);
        }
    }
}
