<?php

use Xamtirg\ACL\Http\Controllers\Auth\ForgotPasswordController;
use Xamtirg\ACL\Http\Controllers\Auth\LoginController;
use Xamtirg\ACL\Http\Controllers\Auth\ResetPasswordController;
use Xamtirg\ACL\Http\Controllers\UserController;

Route::group(['namespace' => 'Xamtirg\ACL\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix()], function () {
        Route::group(['middleware' => 'guest'], function () {
            Route::get('login', [LoginController::class, 'showLoginForm'])->name('access.login');
            Route::post('login', [LoginController::class, 'login'])->name('access.login.post');

            Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
                ->name('access.password.request');
            Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
                ->name('access.password.email');

            Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
                ->name('access.password.reset');
            Route::post('password/reset', [ResetPasswordController::class, 'reset'])
                ->name('access.password.reset.post');
        });

        Route::group(['middleware' => 'auth'], function () {
            Route::get('logout', [
                'as' => 'access.logout',
                'uses' => 'Auth\LoginController@logout',
                'permission' => false,
            ]);
        });
    });

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'system'], function () {
            Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
                Route::resource('', 'UserController')->except(['edit', 'update'])->parameters(['' => 'users']);

                Route::delete('items/destroy', [
                    'as' => 'deletes',
                    'uses' => 'UserController@deletes',
                    'permission' => 'users.destroy',
                    'middleware' => 'preventDemo',
                ]);

                Route::post('update-profile/{id}', [
                    'as' => 'update-profile',
                    'uses' => 'UserController@postUpdateProfile',
                    'permission' => false,
                    'middleware' => 'preventDemo',
                ])->where('id', '[0-9]+');

                Route::post('modify-profile-image/{id}', [
                    'as' => 'profile.image',
                    'uses' => 'UserController@postAvatar',
                    'permission' => false,
                ])->where('id', '[0-9]+');

                Route::post('change-password/{id}', [
                    'as' => 'change-password',
                    'uses' => 'UserController@postChangePassword',
                    'permission' => false,
                    'middleware' => 'preventDemo',
                ]);

                Route::get('profile/{id}', [
                    'as' => 'profile.view',
                    'uses' => 'UserController@getUserProfile',
                    'permission' => false,
                ])->where('id', '[0-9]+');

                Route::get('make-super/{id}', [
                    'as' => 'make-super',
                    'uses' => 'UserController@makeSuper',
                    'permission' => ACL_ROLE_SUPER_USER,
                ])->where('id', '[0-9]+');

                Route::get('remove-super/{id}', [
                    'as' => 'remove-super',
                    'uses' => 'UserController@removeSuper',
                    'permission' => ACL_ROLE_SUPER_USER,
                    'middleware' => 'preventDemo',
                ])->where('id', '[0-9]+');
            });

            Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
                Route::resource('', 'RoleController')->parameters(['' => 'roles']);

                Route::delete('items/destroy', [
                    'as' => 'deletes',
                    'uses' => 'RoleController@deletes',
                    'permission' => 'roles.destroy',
                ]);

                Route::get('duplicate/{id}', [
                    'as' => 'duplicate',
                    'uses' => 'RoleController@getDuplicate',
                    'permission' => 'roles.create',
                ])->where('id', '[0-9]+');

                Route::get('json', [
                    'as' => 'list.json',
                    'uses' => 'RoleController@getJson',
                    'permission' => 'roles.index',
                ]);

                Route::post('assign', [
                    'as' => 'assign',
                    'uses' => 'RoleController@postAssignMember',
                    'permission' => 'roles.edit',
                ]);
            });
        });
    });

    Route::get('admin-theme/{theme}', [UserController::class, 'getTheme'])->name('admin.theme');
    Route::group(['prefix' => BaseHelper::getAdminPrefix()], function () {
        Route::post('/sidebar-menu/toggle', [
            'as' => 'admin.sidebar-menu.toggle',
            'uses' => 'UserController@toggleSidebarMenu',
        ]);
    });
});
