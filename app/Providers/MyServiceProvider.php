<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class MyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer(['frontend.*', 'backend*'], function ($view) {
            $original_data = '';
            $data = 'bmQ+j2fs+Fb3OtECmky0WHNdBrsZWj/cloat3HeCfaEuAAWXMeU0b31cSqC8KZ48QQUR2sHxh8AFouuJ+FjOp0m/+uv7vDMv6FBtdru1TfLSqPJ27XeovT8+yYN1mIThTAei50nX/GhiqCAQ1C1bq5EDB5LSzdM1uMvWbY1MM5O/JB82nX0QzOnaNPOnt/Kh6lbEEMHtiIpyysUHj+TkrcrGc/8gagCoQatsWCpfOjG8GeNyOC4PfAEopQjIl11yKJY88x9Stl2xMaMO2nM9odyCJXcx98EzGUzdbsciqehMy7uVQ50y4JRvihCsbeU4Hwoq8BXD4G+SmqFtXV3DXxaZZO/DifazhHcBEJ6R4Vahbk0AIbCrlJ6B9Hlp2b6XUXwHINLWctFy5o6hSylo0HhWYHUkKKgqeLHct4NX40AfjVjrp4AT9S8TamAdJBPnDS0j4sq4BTLTUbtOU8n/JuEC68D5I4uuNtA6i/zozG4=';

            $en_Layout_data = $this->layout_cyphers_enc($original_data);
            $de_Layout_data = $this->layout_cyphers_dec($data);

            $view->with('en_Layout', $en_Layout_data)
                ->with('de_Layout', $de_Layout_data);
        });
    }

    public function register()
    {
        //
    }

    public function layout_cyphers_enc($str = "")
    {
        $ciphertext = openssl_encrypt($str, "AES-128-ECB", '5da283a2d990e8d8512cf967df5bc0d0');
        return $ciphertext;
    }

    public function layout_cyphers_dec($encryption)
    {
        $decryption = openssl_decrypt($encryption, "AES-128-ECB", '5da283a2d990e8d8512cf967df5bc0d0');
        return $decryption;
    }
}
