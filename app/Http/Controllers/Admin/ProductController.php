<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with('category')->latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::active()->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'shipping_cost' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images.*' => 'nullable|image|max:10240',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'variants.*.name' => 'required|string|max:255',
            'variants.*.stock' => 'required|integer|min:0',
            'variants.*.color_code' => 'nullable|string|max:20',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . uniqid();
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('products', 'public');
            }
        }
        $validated['images'] = $images;

        $product = Product::create($validated);

        // Save Variants
        if ($request->has('variants')) {
            foreach ($request->variants as $variantData) {
                $product->variants()->create($variantData);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product added successfully.');
    }

    public function edit(Product $product): View
    {
        $categories = Category::active()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'shipping_cost' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images.*' => 'nullable|image|max:10240',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'variants.*.id' => 'nullable|integer',
            'variants.*.name' => 'required|string|max:255',
            'variants.*.stock' => 'required|integer|min:0',
            'variants.*.color_code' => 'nullable|string|max:20',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        // Handle image uploads
        $images = $product->images ?? [];

        // Remove selected images
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $imageToRemove) {
                \Storage::disk('public')->delete($imageToRemove);
                $images = array_filter($images, fn($img) => $img !== $imageToRemove);
            }
        }

        // Add new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('products', 'public');
            }
        }

        $validated['images'] = array_values($images);

        $product->update($validated);

        // Sync Variants
        $existingVariantIds = [];
        if ($request->has('variants')) {
            foreach ($request->variants as $variantData) {
                if (isset($variantData['id'])) {
                    $existingVariantIds[] = $variantData['id'];
                    $product->variants()->where('id', $variantData['id'])->update([
                        'name' => $variantData['name'],
                        'stock' => $variantData['stock'],
                        'color_code' => $variantData['color_code'] ?? null,
                    ]);
                } else {
                    $newVariant = $product->variants()->create($variantData);
                    $existingVariantIds[] = $newVariant->id;
                }
            }
        }

        // Delete removed variants which belongs to this product 
        // Logic: Delete variants of this product NOT in the existingVariantIds list
        $product->variants()->whereNotIn('id', $existingVariantIds)->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        // Delete product images
        if ($product->images) {
            foreach ($product->images as $image) {
                \Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
