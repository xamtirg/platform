<?php

namespace Xamtirg\ACL\Http\Controllers\Auth;

use Assets;
use BaseHelper;
use Xamtirg\ACL\Traits\ResetsPasswords;
use Xamtirg\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class ResetPasswordController extends BaseController
{
    use ResetsPasswords;

    protected string $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
        $this->redirectTo = BaseHelper::getAdminPrefix();
    }

    public function showResetForm(Request $request, $token = null)
    {
        page_title()->setTitle(trans('core/acl::auth.reset.title'));

        Assets::addScripts(['jquery-validation'])
            ->addScriptsDirectly('vendor/core/core/acl/js/login.js')
            ->addStylesDirectly('vendor/core/core/acl/css/animate.min.css')
            ->addStylesDirectly('vendor/core/core/acl/css/login.css')
            ->removeStyles([
                'select2',
                'fancybox',
                'spectrum',
                'simple-line-icons',
                'custom-scrollbar',
                'datepicker',
            ])
            ->removeScripts([
                'select2',
                'fancybox',
                'cookie',
            ]);

        $email = $request->input('email');

        return view('core/acl::auth.reset', compact('email', 'token'));
    }
}
