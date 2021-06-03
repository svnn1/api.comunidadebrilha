<?php

namespace App\Http\Controllers\Admin\Acl;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Acl\StoreRoleRequest;
use App\Http\Requests\Admin\Acl\UpdateRoleRequest;
use App\Contracts\Repositories\Admin\Acl\RoleRepository;

/**
 * Class RoleController
 *
 * @package App\Http\Controllers\Admin\Acl
 */
class RoleController extends Controller
{
  /**
   * @var \App\Contracts\Repositories\Admin\Acl\RoleRepository
   */
  private RoleRepository $roleRepository;

  public function __construct(RoleRepository $roleRepository)
  {
    $this->roleRepository = $roleRepository;
  }

  public function index(): JsonResponse
  {
    $roles = $this->roleRepository->newQuery()->get();

    return response()->json([
      'data' => $roles,
    ], Response::HTTP_OK);
  }

  public function store(StoreRoleRequest $request): JsonResponse
  {
    $role = $this->roleRepository->create($request->validated());

    return response()->json([
      'data' => $role,
    ], Response::HTTP_CREATED);
  }

  public function show(string $permissionId): JsonResponse
  {
    $role = $this->roleRepository->find($permissionId);

    return response()->json([
      'data' => $role,
    ], Response::HTTP_OK);
  }

  public function update(UpdateRoleRequest $request, string $permissionId): JsonResponse
  {
    $role = $this->roleRepository->find($permissionId);

    $this->roleRepository->update($role, $request->validated());

    return response()->json([
      'data' => $role,
    ], Response::HTTP_OK);
  }

  public function destroy(string $permissionId): JsonResponse
  {
    $role = $this->roleRepository->find($permissionId);

    $this->roleRepository->delete($role);

    return response()->json([], Response::HTTP_NO_CONTENT);
  }
}
