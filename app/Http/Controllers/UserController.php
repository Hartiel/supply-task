<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct(
        protected UserService $service
    ) {}

    public function index()
    {
        return Inertia::render('Users/Index', [
            'users' => $this->service->listUsers()
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $this->service->registerNewUser($request->validated());
        
        return redirect()->route('users.index')
            ->with('message', 'Usuário criado com sucesso.');
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $this->service->updateUserInfo($id, $request->validated());
        
        return redirect()->route('users.index')
            ->with('message', 'Usuário atualizado com sucesso.');
    }

    public function destroy($id)
    {
        // Não permitir o admin se auto-deletar
        if (auth()->id() == $id) {
            return back()->withErrors(['error' => 'Você não pode excluir sua própria conta.']);
        }

        $this->service->deleteUser($id);
        return redirect()->route('users.index')
            ->with('message', 'Usuário apagado com sucesso.');
    }
}