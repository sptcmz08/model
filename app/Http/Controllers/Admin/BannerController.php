<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:10240',
            'title' => 'nullable|string|max:255',
        ]);

        // Deactivate all existing logos
        Banner::query()->update(['is_active' => false]);

        $banner = new Banner();
        $banner->title = $request->title ?? 'Logo';
        $banner->order = 0;
        $banner->is_active = true; // Auto-activate new logo

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('banners', 'public');
            $banner->image_path = $path;
        }

        $banner->save();

        return redirect()->route('admin.banners.index')->with('success', 'Logo uploaded successfully.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'title' => 'nullable|string|max:255',
            'link' => 'nullable|url',
            'order' => 'integer',
        ]);

        $banner->title = $request->title;
        $banner->link = $request->link;
        $banner->order = $request->order ?? 0;
        $banner->is_active = $request->has('is_active');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($banner->image_path) {
                // Handle both prefixed and unprefixed paths for deletion
                $oldPath = str_replace('storage/', '', $banner->image_path);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('banners', 'public');
            $banner->image_path = $path;
        }

        $banner->save();

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image_path) {
            $oldPath = str_replace('storage/', '', $banner->image_path);
            Storage::disk('public')->delete($oldPath);
        }
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully.');
    }
}
