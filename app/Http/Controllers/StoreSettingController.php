<?php

namespace App\Http\Controllers;

use App\Models\StoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = StoreSetting::getSettings();
        return view('store-settings.index', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'store_address' => 'required|string',
            'store_phone' => 'required|string|max:20',
            'store_email' => 'nullable|email',
            'store_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'currency' => 'required|string|max:3',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'enable_tax' => 'boolean',
            'enable_barcode' => 'boolean',
            'enable_serial_number' => 'boolean',
        ]);

        $settings = StoreSetting::getSettings();
        $data = $request->all();

        // Handle logo upload
        if ($request->hasFile('store_logo')) {
            // Delete old logo
            if ($settings->store_logo) {
                Storage::disk('public')->delete($settings->store_logo);
            }
            $data['store_logo'] = $request->file('store_logo')->store('store', 'public');
        }

        $settings->update($data);

        return redirect()->route('store-settings.index')
            ->with('success', 'Pengaturan toko berhasil diperbarui.');
    }
}






