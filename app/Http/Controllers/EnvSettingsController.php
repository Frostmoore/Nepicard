<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;



class EnvSettingsController extends Controller
{
    public function edit(): \Illuminate\View\View
    {
        $lines = file(base_path('.env'));
        $env = collect($lines)
            ->filter(fn($line) => str_contains($line, '='))
            ->mapWithKeys(function ($line) {
                [$key, $val] = explode('=', $line, 2);
                $key = trim($key);
                $val = trim($val, "\" \n\r");
                return [$key => $val];
            });

        $appSettings = $env->filter(fn($val, $key) => str_starts_with($key, 'APP_') && !in_array($key, ['APP_KEY', 'APP_ENV']));
        $dbSettings = $env->filter(fn($val, $key) => str_starts_with($key, 'DB_'));
        $mailSettings = $env->filter(fn($val, $key) => str_starts_with($key, 'MAIL_'));

        return view('admin.env.env-settings', compact('appSettings', 'dbSettings', 'mailSettings'));
    }


    

    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        $envPath = base_path('.env');
        $current = file($envPath);
        $new = [];

        foreach ($current as $line) {
            if (str_contains($line, '=')) {
                [$key, $val] = explode('=', $line, 2);
                $key = trim($key);

                if ($request->has($key)) {
                    // 1. Ottieni il valore dal form
                    $input = $request->input($key);

                    // 2. Rimuovi eventuali virgolette esterne
                    $input = trim($input, '"');

                    // 3. Escape delle virgolette interne
                    $escaped = str_replace('"', '\"', $input);

                    // 4. Se contiene spazi o simboli, racchiudi tra virgolette
                    $finalValue = preg_match('/\s|=|#|\'|\"/', $escaped) ? "\"$escaped\"" : $escaped;

                    // 5. Salva la riga aggiornata
                    $new[] = "{$key}={$finalValue}\n";
                } else {
                    $new[] = $line;
                }
            } else {
                $new[] = $line;
            }
        }

        file_put_contents($envPath, implode('', $new));

        return redirect()->back()->with('success', 'Impostazioni .env aggiornate con successo.');
    }

    

    private static function setEnvValue($key, $value)
    {
        $envPath = base_path('.env');
        $escaped = preg_quote("{$key}=", '/');

        $envContent = File::get($envPath);
        $pattern = "/^{$escaped}.*/m";

        if (preg_match($pattern, $envContent)) {
            $envContent = preg_replace($pattern, "{$key}=\"{$value}\"", $envContent);
        } else {
            $envContent .= "\n{$key}=\"{$value}\"";
        }

        File::put($envPath, $envContent);
    }

}
