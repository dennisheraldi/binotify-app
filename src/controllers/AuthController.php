<?php
namespace MusicApp\Controllers;

use MusicApp\Core\Controller;
use MusicApp\Core\Models\Validation;
use MusicApp\Models\User;

use function MusicApp\Core\back;
use function MusicApp\Core\has;
use function MusicApp\Core\remove;
use function MusicApp\Core\route;
use function MusicApp\Core\set;
use function MusicApp\Core\view;

class AuthController extends Controller {
    public function loginForm() {
        if (has('user'))
            route('home');
        else
            view('auth.login');
    }

    public function login() {
        $flash = ([
            'errors' => [],
            'values' => [
                'username' => $_POST['username'] ?? '',
                'password' => $_POST['password'] ?? ''
            ]
        ]);
        if (!isset($_POST['username']))
            $flash['errors']['username'] = 'Username is required';
        if (!isset($_POST['password']))
            $flash['errors']['password'] = 'Password is required';
        if (count($flash['errors']) > 0) {
            back()->with($flash);
            return;
        }
        $users = User::find('username = ?', [$flash['values']['username']], 'LIMIT 1');
        if ($users) {
            $user = $users[0];
            if (password_verify($flash['values']['password'], $user->password)) {
                set('user', $user);
                route('home');
            } else {
                $flash['errors']['password'] = 'Password is incorrect.';
                back()->flash($flash);
            }
        } else {
            $flash['errors']['username'] = 'Username is not found!';
            back()->flash($flash);
        }
    }

    public function registerForm() {
        if (has('user'))
            route('home');
        else
            view('auth.register');
    }

    public function register() {
        $flash = ([
            'errors' => [],
            'values' => [
                'name' => $_POST['name'] ?? null,
                'username' => $_POST['username'] ?? null,
                'email' => $_POST['email'] ?? null,
                'password' => $_POST['password'] ?? null
            ]
        ]);
        if (!isset($_POST['password_confirm']) || $_POST['password_confirm'] !== $_POST['password'])
            $flash['errors']['password_confirm'] = 'Password confirmation does not match';
        $user = new User();
        $user->set($flash['values']);
        $valid = $user->validate([
            'name' => [
                Validation::TYPE => Validation::T_STRING,
            ],
            'username' => [
                Validation::TYPE => Validation::T_USERNAME,
                Validation::REQUIRED,
                Validation::UNIQUE => User::class,
            ],
            'email' => [
                Validation::TYPE => Validation::T_EMAIL,
                Validation::REQUIRED,
                Validation::UNIQUE => User::class,
            ],
            'password' => [
                Validation::TYPE => Validation::T_STRING,
                Validation::REQUIRED,
                Validation::MIN => 8,
            ],
        ]);
        $flash['errors'] = array_merge($flash['errors'], $valid);
        $flash['values']['password_confirm'] = $_POST['password_confirm'] ?? null;
        if (count($flash['errors']) > 0) {
            back()->flash($flash);
            return;
        }
        $user->setPassword($_POST['password']); // hash password
        $user->save();
        set('user', $user);
        route('home');
    }

    public function logout() {
        remove('user');
        route('home');
    }

    public function checkUsername($username) {
        $users = User::find('username = ?', [$username], 'LIMIT 1');
        echo $users ? 'false' : 'true';
    }

    public function checkEmail($email) {
        $users = User::find('email = ?', [$email], 'LIMIT 1');
        echo $users ? 'false' : 'true';
    }
}

?>