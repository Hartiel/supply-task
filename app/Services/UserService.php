<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        protected UserRepository $repository
    ) {}

    public function listUsers(): LengthAwarePaginator
    {
        return $this->repository->getAllPaginated();
    }

    public function registerNewUser(array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->repository->create($data);
    }

    public function updateUserInfo(int $id, array $data): bool
    {
        // Se a senha for enviada na atualização, encripta
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // Evita sobrepor com vazio
        }

        return $this->repository->update($id, $data);
    }
}