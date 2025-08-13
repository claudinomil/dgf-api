<?php

use App\Http\Controllers\UserController;

Route::prefix('users')->group(function () {
    Route::get('/index', [UserController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [UserController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [UserController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [UserController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [UserController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables', [UserController::class, 'auxiliary'])->middleware(['auth:api']);

    Route::get('/profiledata/{id}', [UserController::class, 'profileData'])->middleware(['auth:api']);
    Route::put('/update/avatar/{id}', [UserController::class, 'updateAvatar'])->middleware(['auth:api']);
    Route::put('/edit/password/{id}', [UserController::class, 'editPassword'])->middleware(['auth:api']);
    Route::put('/edit/email/{id}', [UserController::class, 'editEmail'])->middleware(['auth:api']);
    Route::put('/edit/modestyle/{id}', [UserController::class, 'editmodestyle'])->middleware(['auth:api']);

    //Usuário - retorna dados do usuário logado
    Route::get('/user/logged/data', [UserController::class, 'userLoggedData'])->middleware(['auth:api']);

    //Usuário - retorna dados e permissões
    Route::get('/user/permissoes/settings/{searchSubmodulo}', [UserController::class, 'userPermissoesSettings'])->middleware(['auth:api']);

    //Usuário - welcome Permissão
    Route::get('/user/welcome/permissao', [UserController::class, 'userWelcomePermissao'])->middleware(['auth:api']);

    //Logout
    //Route::post('logout', [UserController::class, 'logout'])->middleware(['auth:api']);
});

//Verifica se usuário existe (pelo email)
Route::get('users/exist/{email}', [UserController::class, 'exist']);

//Verifica se usuário foi confirmado (pelo email)
Route::get('users/confirm/{email}', [UserController::class, 'confirm']);

//Alterar campo de confirmação de email (user_confirmed_at)
Route::post('users/confirmupdate', [UserController::class, 'update_confirm']);
