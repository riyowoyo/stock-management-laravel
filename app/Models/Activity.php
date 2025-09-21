<?php

namespace App\Models;

use Spatie\Activitylog\Models\Activity as SpatieActivity;

class Activity extends SpatieActivity
{
    public function getReadableChangesAttribute()
    {
        $changes = $this->changes; // ambil JSON changes dari spatie
        $messages = [];

        if (isset($changes['attributes'])) {
            foreach ($changes['attributes'] as $key => $newValue) {
                $oldValue = $changes['old'][$key] ?? null;

                if ($oldValue !== null && $oldValue != $newValue) {
                    $messages[] = "Mengubah **{$key}** dari `{$oldValue}` menjadi `{$newValue}`";
                } elseif ($oldValue === null) {
                    $messages[] = "Menambahkan **{$key}** dengan nilai `{$newValue}`";
                }
            }
        }

        return implode(', ', $messages);
    }
}
