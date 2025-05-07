<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([
            // Prénom avec majuscule
            'name' => ['required', 'string', 'regex:/^[A-Z][a-zA-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸ-]*$/'],
            
            // Email doit commencer par une minuscule
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                'unique:'.User::class, 
                'regex:/^[a-z]/' // Vérifie que le premier caractère est une minuscule
            ],
    
            // Mot de passe avec au moins 8 caractères
            'password' => ['required', 'confirmed', Rules\Password::defaults(), 'min:8'],
        ], [
            // Messages d'erreur personnalisés
            'name.regex' => 'Le prénom doit commencer par une majuscule.',
            'email.regex' => "L'adresse e-mail doit commencer par une minuscule.",
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->input('password')),
        ]);
    
        event(new Registered($user));
    
        Auth::login($user);
    
        return response()->noContent();
    }
    
    
}
