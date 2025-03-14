<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $testimonials = [
            [
                'name' => 'Jean Martin',
                'avatar' => 'https://ui-avatars.com/api/?name=Jean+Martin',
                'comment' => 'Excellent service, travail soigné et professionnel.'
            ],
            [
                'name' => 'Marie Dubois',
                'avatar' => 'https://ui-avatars.com/api/?name=Marie+Dubois',
                'comment' => 'Intervention rapide et efficace. Je recommande!'
            ],
            [
                'name' => 'Pierre Durand',
                'avatar' => 'https://ui-avatars.com/api/?name=Pierre+Durand',
                'comment' => 'Très satisfait du travail réalisé.'
            ]
        ];
        
        return view('welcome', compact('testimonials'));
    }
}