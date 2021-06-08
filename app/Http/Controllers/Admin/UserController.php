<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\StoreUserRequest;
use App\Http\Requests\Admin\Users\UpdateUserRequest;
use App\Contracts\Repositories\Admin\UserRepository;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Admin
 */
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
    $users = $this->userRepository->all();

    return response()->json([
      'data' => $users,
    ], Response::HTTP_OK);
  }

  public function store(StoreUserRequest $request): JsonResponse
  {
    $user = $this->userRepository->create([
      'name'     => $request->get('name'),
      'email'    => $request->get('email'),
      'password' => bcrypt($request->get('password')),
    ]);

    return response()->json([
      'data' => $user,
    ], Response::HTTP_OK);
  }

  public function show(string $userId): JsonResponse
  {
    $user = $this->userRepository->find($userId);

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

  public function destroy(string $userId): JsonResponse
  {
    $user = $this->userRepository->find($userId);

    $this->userRepository->delete($user);

    return response()->json([], Response::HTTP_NO_CONTENT);
  }
}
