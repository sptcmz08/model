<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutImageController extends Controller
{
    public function index()
    {
        $images = AboutImage::orderBy('order')->get();
        return view('admin.about-images.index', compact('images'));
    }

    public function store(Request $request)
    {
        // Max 2 images allowed
        if (AboutImage::count() >= 2) {
            return redirect()->route('admin.about-images.index')
                ->with('error', 'Maximum 2 images allowed. Please delete an existing image first.');
        }

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $image = new AboutImage();
        $image->order = AboutImage::count();
        $image->is_active = true;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('about', 'public');
            $image->image_path = $path;
        }

        $image->save();

        return redirect()->route('admin.about-images.index')
            ->with('success', 'About image uploaded successfully.');
    }

    public function destroy(AboutImage $about_image)
    {
        if ($about_image->image_path) {
            $oldPath = str_replace('storage/', '', $about_image->image_path);
            Storage::disk('public')->delete($oldPath);
        }
        $about_image->delete();

        return redirect()->route('admin.about-images.index')
            ->with('success', 'Image deleted successfully.');
    }
}
