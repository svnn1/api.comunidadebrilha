<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\StoreUserRequest;
use App\Http\Requests\Admin\Users\UpdateUserRequest;
use App\Contracts\Repositories\Admin\UserRepository;

class UserController extends Controller
{
  /**
   * @var \App\Contracts\Repositories\Admin\UserRepository
   */
  private UserRepository $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function index(): JsonResponse
  {
    $users =$this->userRepository->newQuery()->get();

    return response()->json([
      'data' => $users,
    ], Response::HTTP_OK);
  }

  public function store(StoreUserRequest $request): JsonResponse
  {
    $user = $this->userRepository->create($request->validated());

    return response()->json([
      'data' => $user,
    ], Response::HTTP_OK);
  }

  public function show(string $userId): JsonResponse
  {
    $user = User::find($userId);

    return response()->json([
      'data' => $user,
    ], Response::HTTP_OK);
  }

  public function update(UpdateUserRequest $request, string $userId): JsonResponse
  {
    $user = $this->userRepository->find($userId);

    $this->userRepository->update($user, $request->validated());

    return response()->json([
      'data' => $user,
    ], Response::HTTP_OK);
  }
}
