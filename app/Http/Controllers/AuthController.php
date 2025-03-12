<?php

namespace App\Http\Controllers;

use App\Events\NewUserCreated;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Str;

class AuthController extends Controller
{
    private $secretKey = "qQKPjndxljuYQi/POiXJa8O19nVO/vTf/DpXO541g=qQKPjndxljuYQi/POiXJa8O19nVO/vTf/DpXO541g=";

    /**
     * Registrar un nuevo usuario
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse {

        $fields = $request->validated();

        $user = User::create([
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
            'is_valid_email' => User::IS_INVALID_EMAIL,
            'remember_token' => $this->generateRandomCode(),
        ]);

        NewUserCreated::dispatch($user);

        return response()->json([
            'user' => $user,
            'message' => 'Usuario creado correctamente. Revisa tu correo para validar tu cuenta.'
        ], 201);

    }

    /**
     * Validar el email del usuario
     *
     * @param string $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function validEmail($token): RedirectResponse {

        User::where('remember_token', $token)->update(
            [
                'is_valid_email' => User::IS_VALID_EMAIL,
            ]
        );

        return redirect('/app/login');
    }

    /**
     * Generar un código aleatorio para el token de validación del email
     *
     * @return string $code
     */
    private function generateRandomCode(): string {
        $code = Str::random(10) . time();
        return $code;
    }

    /**
     * Login de usuario
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse {

        $fields = $request->validated();
        $user = $request->getUsers();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json(['message' => 'Usuario o contraseña incorrectos.'], 422);
        }

        $token = $user->createToken($this->secretKey)->plainTextToken;

        return response()->json([
                'user' => $user,
                'message' => "Bienvenido $user->email",
                'token' => $token,
                'isLoggedIn' => true,
        ], 200);
    }

    /**
     * Cerrar sesión
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse {
        DB::table('personal_access_tokens')->where('tokenable_id', $request->userId)->delete();
        return response()->json(['message' => 'Sesión cerrada.'], 200);
    }
}
