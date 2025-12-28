<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class AdminImportController extends Controller
{
    public function importCsv(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:csv,txt']);
        $handle = fopen($request->file('file')->getRealPath(), 'r');
        $header = fgetcsv($handle);
        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);
            $category = Category::firstOrCreate([
                'name' => $data['category'] ?? 'Uncategorized',
            ], ['slug' => Str::slug($data['category'] ?? 'uncategorized').'-'.Str::random(6)]);
            Product::updateOrCreate(
                ['slug' => Str::slug($data['name']).'-'.Str::random(6)],
                [
                    'name' => $data['name'],
                    'category_id' => $category->id,
                    'price' => (float)($data['price'] ?? 0),
                    'stock' => (int)($data['stock'] ?? 0),
                    'description' => $data['description'] ?? null,
                ]
            );
        }
        fclose($handle);
        return back();
    }
}
