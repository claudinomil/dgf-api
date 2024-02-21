<?php

namespace App\Http\Controllers;

use App\API\ApiReturn;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PasswordResetsController extends Controller
{
    public function store(Request $request, $token)
    {
        try {
            //Incluindo registro
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            return response()->json(ApiReturn::data('Registro criado com sucesso.', 2010, null, null), 201);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(ApiReturn::data($e->getMessage(), 5000, null, null), 500);
            }

            return response()->json(ApiReturn::data('Houve um erro ao realizar a operação.', 5000, null, null), 500);
        }
    }

    public function confirm(Request $request)
    {
        try {
            //Confirmando registro
            $updatePassword = DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->token])->first();

            if (!$updatePassword) {
                return response()->json(ApiReturn::data('Registro não encontrado.', 4040, null, null), 404);
            }

            return response()->json(ApiReturn::data('Registro confirmado com sucesso.', 2000, null, null), 200);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(ApiReturn::data($e->getMessage(), 5000, null, null), 500);
            }

            return response()->json(ApiReturn::data('Houve um erro ao realizar a operação.', 5000, null, null), 500);
        }
    }

    public function update_delete(Request $request)
    {
        try {
            //Alterar tabela users
            $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

            //Deletar registro na tabela password_resets
            DB::table('password_resets')->where(['email' => $request->email])->delete();

            if (!$user) {
                return response()->json(ApiReturn::data('Operação não concluída.', 4040, null, null), 404);
            }

            return response()->json(ApiReturn::data('Operações realizadas com sucesso.', 2000, null, null), 200);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(ApiReturn::data($e->getMessage(), 5000, null, null), 500);
            }

            return response()->json(ApiReturn::data('Houve um erro ao realizar a operação.', 5000, null, null), 500);
        }
    }
}
