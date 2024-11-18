<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Firebase\JWT\JWT;
use Laravel\Socialite\Facades\Socialite;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\AuthException;

class UsersController extends Controller
{
    // protected $firebaseAuth;

    // public function __construct()
    // {
    //     // Inisialisasi Firebase Auth
    //     $this->firebaseAuth = (new Factory)
    //         ->withServiceAccount(config('firebase.credentials_file'))
    //         ->createAuth();
    // }


    public function register(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string'
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->save();

        return response()->json($user, 201);

        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password)
        // ]);

        // $token = JWTAuth::fromUser($user);

        // return response()->json(['token' => $token]);

        // $user = new User();
        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->password = Hash::make($request->password);
        // $user->save();

        // return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function login(Request $request)
    {
        $validated = $this->validate($request, [
            'email' => 'required|exists:users,email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $validated['email'])->first();
        if(!Hash::check($validated['password'], $user->password)){
            return abort(401, "email or password not valid");
        }

        $payload = [
            'iat' => intval(microtime(true)),
            'exp' => intval(microtime(true)) + (60*60*1000),
            'uid' => $user->id
        ];

        $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

        return response()->json(['access_token' => $token]);

        // $credentials = $request->only('email', 'password');

        // if (!$token = JWTAuth::attempt($credentials)) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        // return response()->json(['token' => $token]);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

    // Debugging: Periksa isi $googleUser
    if (is_null($googleUser)) {
        return response()->json(['error' => 'Google user not found.'], 404);
    }

    // Cek jika properti yang dibutuhkan ada dalam $googleUser
    $email = $googleUser->getEmail();
    if (empty($email)) {
        return response()->json(['error' => 'Email not found in Google user data.'], 404);
    }

    // Mencari atau membuat pengguna berdasarkan email dari Google
    $user = User::firstOrCreate(
        ['email' => $email],
        [
            'name' => $googleUser->getName(),
            'password' => Hash::make(uniqid()) // Atau bisa gunakan token random
        ]
    );

    $payload = [
        'iat' => intval(microtime(true)),
        'exp' => intval(microtime(true)) + (60 * 60 * 1000),
        'uid' => $user->id
    ];

    // Buat token JWT
    $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

    return response()->json(['access_token' => $token]);

    }

    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

}
