<?php

return [
    'required' => 'Le champ :attribute est obligatoire.',
    'min' => [
        'string' => 'Le champ :attribute doit contenir au moins :min caractères.',
        'numeric' => 'Le champ :attribute doit être au moins :min.',
    ],
    'email' => 'Le champ :attribute doit être une adresse email valide.',
    'unique' => 'Cette valeur de :attribute est déjà utilisée.',
    'confirmed' => 'La confirmation du :attribute ne correspond pas.',
    'size' => [
        'string' => 'Le champ :attribute doit contenir exactement :size caractères.',
    ],
    'numeric' => 'Le champ :attribute doit être un nombre.',
    'accepted' => 'Vous devez accepter les :attribute.',

    'attributes' => [
        'name' => 'nom',
        'email' => 'email',
        'password' => 'mot de passe',
        'phone' => 'téléphone',
        'business_name' => 'nom de l\'entreprise',
        'siret' => 'numéro SIRET',
        'specialty' => 'spécialité',
        'description' => 'description',
        'experience_years' => 'années d\'expérience',
        'hourly_rate' => 'taux horaire',
        'service_area' => 'zone de service',
        'city' => 'ville',
        'postal_code' => 'code postal',
        'terms' => 'conditions générales',
    ],
];
