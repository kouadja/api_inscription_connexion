<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function inscription(Request $request)
    {

        $utilisateurDonne = $request->validate([

            'name' => ['string', 'max:30', 'min:3'],
            'email' => ['email', 'max:30', 'min:8', 'unique:users,email'],
            'password' => ['string', 'max:30', 'min:3', 'confirmed'],

        ]);
        $utilisateurs = User::create([
            'name' => $utilisateurDonne['name'],
            'email' => $utilisateurDonne['email'],
            'password' => bcrypt($utilisateurDonne["password"]),
            // 'repeatPassword'=>$utilisateurDonne['repeatPassword']

        ]);
        return response($utilisateurs, 201);
        // return $utilisateur;

    }
    public function connection(Request $request)
    {
        $utilisateurDonnes = $request->validate([

            'email' => ['required', 'email'],
            'password' => ['required', 'string'],

        ]);

        $utilisateur = User::where("email", $utilisateurDonnes['email'])->first();

        if (!$utilisateur) {
            return response(["message" => 'ce email ne correspond à aucun compte'], 404);
        }

        if (!Hash::check($utilisateurDonnes["password"], $utilisateur->password)) {
            return response(["message" => 'ce mot de passe est incorrect '], 404);
        }


        $token = $utilisateur->createToken("auth_token")->plainTextToken;
        return response([
            'utilisateur' => $utilisateur,
            "token" => $token
        ]);
    }
    public function deconnection()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response(["message" => "Deconnection!!!"], 200);
    }
}
