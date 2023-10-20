<?php

use App\Facade\Validator;
use App\Model\User;
use App\Validation\Rules\EmailRule;
use App\Validation\Rules\LengthRule;
use App\Validation\Rules\NullableRule;
use App\Validation\Rules\PasswordConfirmationRule;
use App\Validation\Rules\PasswordRule;
use App\Validation\Rules\RequiredRule;

$app = require __DIR__.'/bootstrap/app.php';



function getAllRequest() {
    http_response_code(200);
    return json_encode(User::all());
}

function getRequest(int $id) {

    $user = User::get($id);
    if(!isset($user)) {
        http_response_code(404);
        return json_encode([
            'error' => 'L\'utilisateur n\'a pas pu être trouvé.'
        ]);
    }

    http_response_code(200);
    return json_encode($user);
}

function createRequest(array $data) {
    $validator = Validator::build([
        'name' => [new RequiredRule(), (new LengthRule())->min(2)],
        'email' => [new RequiredRule(), new EmailRule()],
        'password' => [new NullableRule(), (new PasswordRule())->min(8)->special()->mixedCase()->numbers()],
        'confirm' => [new PasswordConfirmationRule()]
    ], $data);

    if(!$validator->valid()) {
        http_response_code(400);
        return json_encode([
            'error' => 'Les paramètres sont incorrects.',
            'errors' => $validator->errors()
        ]);
    }

    $user = User::create($data);

    if(!isset($user)) {
        http_response_code(400);
        return json_encode([
            'error' => 'L\'utilisateur n\'a pas pu être créé.'
        ]);
    }

    http_response_code(200);
    return json_encode($user);
}

function deleteRequest(int $id) {
    $user = User::get($id);
    if(!isset($user)) {
        http_response_code(404);
        return json_encode([
            'error' => 'L\'utilisateur n\'a pas pu être trouvé.'
        ]);
    }

    if(!$user->delete()) {
        http_response_code(500);
        return json_encode([
            'error' => 'Erreur du serveur.'
        ]);
    }
    
    http_response_code(204);
    return null;
}


$body = file_get_contents('php://input');