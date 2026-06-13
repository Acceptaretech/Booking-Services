<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemConfig;
use App\Models\Tax;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    private function getSettingsData(): array
    {
        return [
            'configs' => SystemConfig::query()
                ->get()
                ->keyBy('key'),

            'zones' => Zone::query()
                ->latest()
                ->get(),

            'taxes' => Tax::query()
                ->latest()
                ->get(),
        ];
    }

    public function index()
    {
        return view(
            'admin.settings.index',
            $this->getSettingsData()
        );
    }

    public function general()
    {
        return view(
            'admin.settings.pages.general',
            $this->getSettingsData()
        );
    }

    public function theme()
    {
        return view(
            'admin.settings.pages.theme',
            $this->getSettingsData()
        );
    }

    public function site()
    {
        return view(
            'admin.settings.pages.site',
            $this->getSettingsData()
        );
    }

    public function service()
    {
        return view(
            'admin.settings.pages.service',
            $this->getSettingsData()
        );
    }
    public function updateService(Request $request)
    {
        $serviceSettings = [
            'advanced_payment_services',
            'slot_services',
            'digital_services',
            'service_packages',
            'service_addons',
            'job_request',
            'shop',
            'default_advance_payment',
            'cancellation_charge',
        ];

        foreach ($serviceSettings as $key) {
            SystemConfig::updateOrCreate(
                ['key' => $key],
                ['value' => $request->boolean($key) ? '1' : '0']
            );
        }

        return back()->with('success', 'Service configurations updated successfully.');
    }
    public function app()
    {
        return view(
            'admin.settings.pages.app',
            $this->getSettingsData()
        );
    }

    public function notification()
    {
        return view(
            'admin.settings.pages.notification',
            $this->getSettingsData()
        );
    }

    public function social()
    {
        return view(
            'admin.settings.pages.social',
            $this->getSettingsData()
        );
    }

    public function cookie()
    {
        return view(
            'admin.settings.pages.cookie',
            $this->getSettingsData()
        );
    }

    public function roles()
    {
        return view(
            'admin.settings.pages.roles',
            $this->getSettingsData()
        );
    }

    public function mail()
    {
        return view(
            'admin.settings.pages.mail',
            $this->getSettingsData()
        );
    }
    public function updateMail(Request $request)
    {
        $request->validate([
            'mail_mailer'       => 'nullable|string|max:100',
            'mail_host'         => 'nullable|string|max:255',
            'mail_port'         => 'nullable|string|max:20',
            'mail_encryption'   => 'nullable|string|max:50',
            'mail_username'     => 'nullable|string|max:255',
            'mail_password'     => 'nullable|string|max:255',
            'mail_from_address' => 'nullable|email|max:255',
        ]);

        foreach ($request->except('_token') as $key => $value) {
            SystemConfig::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Mail settings updated successfully.');
    }

    public function payment()
    {
        return view(
            'admin.settings.pages.payment',
            $this->getSettingsData()
        );
    }
    public function updatePayment(Request $request)
{
    $gateway = $request->gateway;

    $allowedGateways = [
        'cash_on_delivery',
        'stripe',
        'razorpay',
        'flutterwave',
        'paypal',
        'cinet',
        'sadad',
        'airtel_money',
        'paystack',
        'phonepe',
        'midtrans',
    ];

    abort_unless(in_array($gateway, $allowedGateways), 404);

    $keys = [
        "{$gateway}_status",
        "{$gateway}_credential_type",
        "{$gateway}_gateway_name",
        "{$gateway}_url",
        "{$gateway}_key",
        "{$gateway}_public_key",
    ];

    foreach ($keys as $key) {
        SystemConfig::updateOrCreate(
            ['key' => $key],
            ['value' => $request->input($key, '0')]
        );
    }

    return back()->with('success', 'Payment settings updated successfully.');
}
    public function earning()
    {
        return view(
            'admin.settings.pages.earning',
            $this->getSettingsData()
        );
    }

    public function language()
    {
        return view(
            'admin.settings.pages.language',
            $this->getSettingsData()
        );
    }

    public function banner()
    {
        return view(
            'admin.settings.pages.banner',
            $this->getSettingsData()
        );
    }

    public function seo()
    {
        return view(
            'admin.settings.pages.seo',
            $this->getSettingsData()
        );
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name'       => 'nullable|string|max:255',
            'contact_number'     => 'nullable|string|max:30',
            'contact_email'      => 'nullable|email|max:255',
            'company_address'    => 'nullable|string|max:1000',
            'footer_description' => 'nullable|string|max:1000',

            'logo'               => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'favicon'            => 'nullable|image|mimes:jpg,jpeg,png,webp,ico|max:1024',

            'social_facebook'    => 'nullable|url|max:500',
            'social_twitter'     => 'nullable|url|max:500',
            'social_instagram'   => 'nullable|url|max:500',
            'social_linkedin'    => 'nullable|url|max:500',
            'social_youtube'     => 'nullable|url|max:500',

            'google_play_url'    => 'nullable|url|max:500',
            'app_store_url'      => 'nullable|url|max:500',

            'razorpay_key'       => 'nullable|string|max:255',
            'razorpay_secret'    => 'nullable|string|max:255',
            'stripe_key'         => 'nullable|string|max:255',
            'stripe_secret'      => 'nullable|string|max:255',

            'meta_title'         => 'nullable|string|max:255',
            'meta_description'   => 'nullable|string|max:1000',
            'meta_keywords'      => 'nullable|string|max:500',
        ]);

        $textSettings = $request->except([
            '_token',
            '_method',
            'logo',
            'favicon',
        ]);

        foreach ($textSettings as $key => $value) {
            SystemConfig::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $this->uploadSettingFile($request, 'logo');
        $this->uploadSettingFile($request, 'favicon');

        return back()->with(
            'success',
            'Settings saved successfully.'
        );
    }

    private function uploadSettingFile(Request $request, string $key): void
    {
        if (!$request->hasFile($key)) {
            return;
        }

        $oldFile = SystemConfig::where('key', $key)->value('value');

        if ($oldFile && Storage::disk('public')->exists($oldFile)) {
            Storage::disk('public')->delete($oldFile);
        }

        $path = $request->file($key)->store('settings', 'public');

        SystemConfig::updateOrCreate(
            ['key' => $key],
            ['value' => $path]
        );
    }

    public function storeTax(Request $request)
    {
        $validated = $request->validate([
            'title'  => 'required|string|max:255',
            'value'  => 'required|numeric|min:0',
            'type'   => 'required|in:percent,fixed',
            'status' => 'required|in:active,inactive',
        ]);

        Tax::create($validated);

        return back()->with(
            'success',
            'Tax added successfully.'
        );
    }

    public function storeZone(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'status'  => 'required|in:active,inactive',
        ]);

        Zone::create($validated);

        return back()->with(
            'success',
            'Zone added successfully.'
        );
    }
}