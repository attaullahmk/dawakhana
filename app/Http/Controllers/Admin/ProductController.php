<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $locale = request('locale', 'all');
        $query = Product::with('category')->latest();
        if ($locale !== 'all') {
            $query->where('locale', $locale);
        }
        $products = $query->get();
        return view('admin.products.index', compact('products', 'locale'));
    }

    public function create()
    {
        $categories = Category::all();
        $locales = ['en' => 'English', 'ur' => 'Urdu (اردو)'];
        return view('admin.products.create', compact('categories', 'locales'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'locale' => 'required|in:en,ur',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'is_active' => 'in:0,1',
            'is_featured' => 'in:0,1',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        
        if ($request->hasFile('main_image')) {
            $imagePath = $request->file('main_image')->store('products', 'public');
            $validated['main_image'] = '/storage/' . $imagePath;
        }

        $validated['is_active'] = $request->input('is_active', 0);
        $validated['is_featured'] = $request->input('is_featured', 0);

        $product = Product::create($validated);

        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $index => $image) {
                $imagePath = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => '/storage/' . $imagePath,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $locales = ['en' => 'English', 'ur' => 'Urdu (اردو)'];
        return view('admin.products.edit', compact('product', 'categories', 'locales'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $id,
            'locale' => 'required|in:en,ur',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $id,
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'is_active' => 'in:0,1',
            'is_featured' => 'in:0,1',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        
        if ($request->hasFile('main_image')) {
            if ($product->main_image && str_starts_with($product->main_image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $product->main_image));
            }
            
            $imagePath = $request->file('main_image')->store('products', 'public');
            $validated['main_image'] = '/storage/' . $imagePath;
        }

        $validated['is_active'] = $request->input('is_active', 0);
        $validated['is_featured'] = $request->input('is_featured', 0);

        $product->update($validated);

        if ($request->hasFile('additional_images')) {
            // For simplicity in this edit, append additional images, or we can add delete options later.
            // But let's set sort_order based on existing images count
            $startOrder = $product->images()->max('sort_order') ?? 0;
            foreach ($request->file('additional_images') as $index => $image) {
                $imagePath = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => '/storage/' . $imagePath,
                    'sort_order' => $startOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->main_image && str_starts_with($product->main_image, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $product->main_image));
        }

        foreach($product->images as $image) {
            if ($image->image_path && str_starts_with($image->image_path, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $image->image_path));
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function destroyImage($id)
    {
        $image = \App\Models\ProductImage::findOrFail($id);
        
        if ($image->image_path && str_starts_with($image->image_path, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $image->image_path));
        }
        
        $image->delete();
        
        return redirect()->back()->with('success', 'Image removed successfully.');
    }
}
