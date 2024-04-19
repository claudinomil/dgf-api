<?php

use App\Http\Controllers\UserController;

Route::prefix('users')->group(function () {
    Route::get('/index', [UserController::class, 'index'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/show/{id}', [UserController::class, 'show'])->middleware(['auth:api', 'scope:claudino']);
    Route::get('/filter/{array_dados}', [UserController::class, 'filter'])->middleware(['auth:api', 'scope:claudino']);
    Route::post('/store', [UserController::class, 'store'])->middleware(['auth:api', 'scope:claudino']);
    Route::put('/update/{id}', [UserController::class, 'update'])->middleware(['auth:api', 'scope:claudino']);
    Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->middleware(['auth:api', 'scope:claudino']);

    Route::get('/auxiliary/tables', [UserController::class, 'auxiliary'])->middleware(['auth:api', 'scope:claudino']);

    Route::get('/profiledata/{id}', [UserController::class, 'profileData'])->middleware(['auth:api', 'scope:claudino']);
    Route::put('/update/avatar/{id}', [UserController::class, 'updateAvatar'])->middleware(['auth:api', 'scope:claudino']);
    Route::put('/edit/password/{id}', [UserController::class, 'editPassword'])->middleware(['auth:api', 'scope:claudino']);
    Route::put('/edit/email/{id}', [UserController::class, 'editEmail'])->middleware(['auth:api', 'scope:claudino']);
    Route::put('/edit/modestyle/{id}', [UserController::class, 'editmodestyle'])->middleware(['auth:api', 'scope:claudino']);

    //Usuário - retorna dados do usuário logado
    Route::get('/user/logged/data', [UserController::class, 'userLoggedData'])->middleware(['auth:api', 'scope:claudino']);

    //Usuário - retorna dados e permissões
    Route::get('/user/permissoes/settings/{searchSubmodulo}', [UserController::class, 'userPermissoesSettings'])->middleware(['auth:api', 'scope:claudino']);

    //Usuário - welcome Permissão
    Route::get('/user/welcome/permissao', [UserController::class, 'userWelcomePermissao'])->middleware(['auth:api', 'scope:claudino']);

    //Logout
    Route::post('logout', [UserController::class, 'logout'])->middleware(['auth:api', 'scope:claudino']);
});

//Verifica se usuário existe (pelo email)
Route::get('users/exist/{email}', [UserController::class, 'exist']);

//Verificar Usuário que está tentando logar
Route::get('users/confirm_user_login/{email}', [UserController::class, 'confirm_user_login']);

//Alterar campo de confirmação de email (email_verified_at)
Route::post('users/confirmupdate', [UserController::class, 'update_confirm']);
