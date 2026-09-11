<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MailSetting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MailSettingController extends Controller
{
    public function edit(): View
    {
        $mailSetting = MailSetting::first() ?? new MailSetting();

        return view('admin.mail-settings.edit', compact('mailSetting'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'mail_host' => ['required', 'string', 'max:255'],
            'mail_port' => ['required', 'string', 'max:10'],
            'mail_username' => ['required', 'string', 'max:255'],
            'mail_password' => ['nullable', 'string', 'max:255'],
            'mail_encryption' => ['required', 'in:tls,ssl'],
            'mail_from_address' => ['required', 'email', 'max:255'],
            'mail_from_name' => ['required', 'string', 'max:255'],
        ]);

        $mailSetting = MailSetting::first() ?? new MailSetting();

        $data = $request->except('mail_password');

        if ($request->filled('mail_password')) {
            $data['mail_password'] = $request->mail_password;
        }

        $mailSetting->fill($data);
        $mailSetting->save();

        return redirect()->route('admin.mail-settings.edit')->with('status', 'Configurações de e-mail salvas com sucesso!');
    }
}