<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class CsrfServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Blade directive for panel-specific CSRF token
        Blade::directive('panelCsrf', function () {
            $panel = request()->attributes->get('panel_context', 'user');
            $token = csrf_token();
            
            if ($panel === 'admin') {
                return "<input type=\"hidden\" name=\"_token\" value=\"{$token}\">\n" .
                       "<meta name=\"csrf-token\" content=\"{$token}\">\n" .
                       "<script>\n" .
                       "    // Set admin panel CSRF token for AJAX requests\n" .
                       "    $.ajaxSetup({\n" .
                       "        headers: {\n" .
                       "            'X-CSRF-TOKEN-ADMIN': '{$token}'\n" .
                       "        }\n" .
                       "    });\n" .
                       "</script>";
            }
            
            return "<input type=\"hidden\" name=\"_token\" value=\"{$token}\">\n" .
                   "<meta name=\"csrf-token\" content=\"{$token}\">\n" .
                   "<script>\n" .
                   "    // Set user panel CSRF token for AJAX requests\n" .
                   "    $.ajaxSetup({\n" .
                   "        headers: {\n" .
                   "            'X-CSRF-TOKEN': '{$token}'\n" .
                       "        }\n" .
                   "    });\n" .
                   "</script>";
        });
        
        // Blade directive for panel-specific meta tag
        Blade::directive('csrfMeta', function () {
            $panel = request()->attributes->get('panel_context', 'user');
            $token = csrf_token();
            $headerName = $panel === 'admin' ? 'X-CSRF-TOKEN-ADMIN' : 'X-CSRF-TOKEN';
            
            return "<meta name=\"csrf-token\" content=\"{$token}\" data-panel=\"{$panel}\" data-header=\"{$headerName}\">";
        });
    }
}
