<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua activity terbaru
        $query = Activity::with('causer')->latest();

        // Hardcode user_id = 1 untuk development
        $query->where('causer_id', 1);

        // Filter event jika ada
        if ($request->event) {
            $eventMap = [
                'created' => ['created', 'ditambahkan'],
                'updated' => ['updated', 'diperbarui'],
                'deleted' => ['deleted', 'dihapus'],
            ];

            $descriptions = $eventMap[$request->event] ?? [];

            $query->where(function ($q) use ($descriptions) {
                foreach ($descriptions as $desc) {
                    $q->orWhere('description', 'like', "%{$desc}%");
                }
            });
        }

        $activities = $query->paginate(10)->withQueryString();

        // Proses activity agar siap untuk view
        $processed = $activities->map(function ($activity) {
            $eventMap = [
                'created' => 'Ditambahkan',
                'updated' => 'Diperbarui',
                'deleted' => 'Dihapus',
            ];

            $desc = $activity->description;
            $eventLabel = 'Lainnya';
            foreach ($eventMap as $key => $label) {
                if (stripos($desc, $key) !== false) {
                    $eventLabel = $label;
                    break;
                }
            }

            // Detail perubahan
            $details = [];

            if ($activity->properties->isNotEmpty()) {
                $old = $activity->properties['old'] ?? [];
                $new = $activity->properties['attributes'] ?? [];

                // Kalau delete, tampilkan produk yang dihapus
                if ($eventLabel === 'Dihapus' && isset($activity->properties['name'])) {
                    $details[] = "Produk: " . $activity->properties['name'];
                } else {
                    $labels = [
                        'name' => 'Nama Produk',
                        'unit' => 'Satuan',
                        'price' => 'Harga',
                        'stock' => 'Stok',
                        'product_id' => 'Produk',
                        'quantity' => 'Jumlah',
                        'description' => 'Deskripsi',
                        'date' => 'Tanggal',
                    ];

                    foreach ($new as $key => $value) {
                        if (in_array($key, ['created_at','updated_at','id','product_code', 'type'])) continue;

                        $label = $labels[$key] ?? ucfirst($key);
                        $oldValue = $old[$key] ?? null;

                        if ($oldValue !== null && $oldValue != $value) {
                            $details[] = "$label: $oldValue → $value";
                        } else {
                            $details[] = "$label: $value";
                        }
                    }
                }
            } else {
                $details[] = "-";
            }

            return [
                'user' => 'Test User', // hardcode
                'event' => $eventLabel,
                'details' => $details,
                'time' => $activity->created_at->format('d M Y H:i'),
            ];
        });

        return view('activities.index', [
            'activities' => $processed,
            'pagination' => $activities,
        ]);
    }
}
