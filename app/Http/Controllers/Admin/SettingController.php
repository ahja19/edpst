<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        return view('admin.payment.edit');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'qr_code' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'bank_name' => ['nullable', 'string', 'max:100'],
            'account_name' => ['nullable', 'string', 'max:100'],
            'account_number' => ['nullable', 'string', 'max:50'],
            'instructions' => ['nullable', 'string', 'max:1000'],
            'contact_phone' => ['nullable', 'string', 'max:30'],
        ]);

        if ($request->hasFile('qr_code')) {
            $old = Setting::get('payment_qr');
            if ($old) {
                Storage::disk('public')->delete($old);
            }
            Setting::set('payment_qr', $request->file('qr_code')->store('qr', 'public'));
        }

        Setting::set('bank_name', $data['bank_name'] ?? '');
        Setting::set('account_name', $data['account_name'] ?? '');
        Setting::set('account_number', $data['account_number'] ?? '');
        Setting::set('instructions', $data['instructions'] ?? '');
        Setting::set('contact_phone', $data['contact_phone'] ?? '');

        return back()->with('success', 'Pengaturan pembayaran diperbarui.');
    }
}