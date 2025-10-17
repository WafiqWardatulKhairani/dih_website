<?php

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/categories/{category}/subcategories', function (Category $category) {
    return $category->subcategories->map(function ($subcategory) {
        return [
            'id' => $subcategory->id,
            'name' => $subcategory->name
        ];
    });
});