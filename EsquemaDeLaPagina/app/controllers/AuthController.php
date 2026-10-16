<?php
declare(strict_types=1);

final class AuthController
{
    public static function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim((string) ($_POST['email'] ?? ''));
            $password = (string) ($_POST['password'] ?? '');
            $user = User::findByEmail($email);

            if ($user === null || !password_verify($password, $user['password_hash'])) {
                flash('error', 'El correo o la contraseña no son correctos.');
            } else {
                session_regenerate_id(true);
                $_SESSION['user'] = [
                    'id' => (int) $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                ];
                redirect($user['role'] === 'admin' ? 'admin' : 'home');
            }
        }

        render_view('login');
    }

    public static function register(): void
    {
        $values = ['name' => '', 'email' => ''];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $values['name'] = trim((string) ($_POST['name'] ?? ''));
            $values['email'] = trim((string) ($_POST['email'] ?? ''));
            $password = (string) ($_POST['password'] ?? '');
            $confirmation = (string) ($_POST['password_confirmation'] ?? '');

            if ($values['name'] === '' || !filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
                flash('error', 'Ingresá tu nombre y un correo electrónico válido.');
            } elseif (strlen($password) < 6) {
                flash('error', 'La contraseña debe tener al menos 6 caracteres.');
            } elseif ($password !== $confirmation) {
                flash('error', 'Las contraseñas no coinciden.');
            } elseif (User::findByEmail($values['email']) !== null) {
                flash('error', 'Ya existe una cuenta con ese correo.');
            } else {
                User::create($values['name'], $values['email'], $password);
                flash('success', 'Tu cuenta está lista. Ya podés iniciar sesión.');
                redirect('login');
            }
        }

        render_view('register', ['values' => $values]);
    }

    public static function logout(): void
    {
        $_SESSION = [];
        session_regenerate_id(true);
        flash('success', 'Cerraste sesión correctamente.');
        redirect('home');
    }
}
