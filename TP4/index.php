<?php

use App\Facade\Validator;
use App\Model\User;
use App\Validation\Rules\DatabaseNotExistsRule;
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
        'email' => [new RequiredRule(), new EmailRule(), (new DatabaseNotExistsRule("users"))->col("email")],
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

    $user = User::createUser($data["name"], $data["email"], $data["password"] ?? null);

    if(!isset($user)) {
        http_response_code(500);
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

function updateRequest(int $id, array $data) {
    $validator = Validator::build([
        'name' => [new NullableRule(), (new LengthRule())->min(2)],
        'email' => [new NullableRule(), new EmailRule(), (new DatabaseNotExistsRule("users"))->col("email")],
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

    $user = User::get($id);

    if(!isset($user)) {
        http_response_code(404);
        return json_encode([
            'error' => 'L\'utilisateur n\'a pas pu être trouvé.'
        ]);
    }

    if(isset($data["name"]))
        $user->name = $data["name"];

    if(isset($data["email"]))
        $user->email = $data["email"];

    if(isset($data["password"]))
        $user->password = $data["password"];

    if(!$user->update()) {
        http_response_code(500);
        return json_encode([
            'error' => 'La mise à jour a échoué.'
        ]);
    }

    http_response_code(200);
    return json_encode($user);
}


$body = file_get_contents('php://input');

if($body != "")
    $data = json_decode($body, true);
else
    $data = [];

$method = $_SERVER['REQUEST_METHOD'];
$path = trim($_SERVER['REQUEST_URI'], '/');

if(str_starts_with($path, "TP4/users")) {
    header('Content-Type: application/json; charset=utf-8');
    $path = trim(substr($path, 9), '/');
    if($path == "") {
        switch($method) {
            case "GET":
                echo getAllRequest();
                break;
            case "POST":
                echo createRequest($data);
                break;
            default:
                http_response_code(405);
                echo json_encode([
                    'error' => "Cette méthode n'est pas disponible pour cet endpoint."
                ]);
        }
    } else {
        if(!is_numeric($path)) {
            http_response_code(400);
            echo json_encode([
                'error' => "L'identifiant de l'utilisateur doit être un nombre."
            ]);
        } else {
            $id = intval($path);
            switch($method) {
                case "GET":
                    echo getRequest($id);
                    break;
                case "PATCH":
                    echo updateRequest($id, $data);
                    break;
                case "DELETE":
                    echo deleteRequest($id);
                    break;
                default:
                    http_response_code(405);
                    echo json_encode([
                        'error' => "Cette méthode n'est pas disponible pour cet endpoint."
                    ]);
            }
        }
    }
}

