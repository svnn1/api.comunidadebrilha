<?php

namespace App\Http\Controllers\Admin\Acl;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Acl\StorePermissionRequest;
use App\Http\Requests\Admin\Acl\UpdatePermissionRequest;
use App\Repositories\Contracts\Acl\PermissionRepository;

/**
 * Class PermissionController
 *
 * @package App\Http\Controllers\Admin\Acl
 */
class PermissionController extends Controller
{
  /**
   * @var \App\Repositories\Contracts\Acl\PermissionRepository
   */
  private PermissionRepository $permissionRepository;

  public function __construct(PermissionRepository $permissionRepository)
  {
    $this->permissionRepository = $permissionRepository;
  }

  public function index(): JsonResponse
  {
    $roles = $this->permissionRepository->newQuery()->get();

    return response()->json([
      'data' => $roles,
    ], Response::HTTP_OK);
  }

  public function store(StorePermissionRequest $request): JsonResponse
  {
    $role = $this->permissionRepository->create($request->validated());

    return response()->json([
      'data' => $role,
    ], Response::HTTP_CREATED);
  }

  public function show(string $permissionId): JsonResponse
  {
    $role = $this->permissionRepository->find($permissionId);

    return response()->json([
      'data' => $role,
    ], Response::HTTP_OK);
  }

  public function update(UpdatePermissionRequest $request, string $permissionId): JsonResponse
  {
    $role = $this->permissionRepository->find($permissionId);

    $this->permissionRepository->update($role, $request->validated());

    return response()->json([
      'data' => $role,
    ], Response::HTTP_OK);
  }

  public function destroy(string $permissionId): JsonResponse
  {
    $role = $this->permissionRepository->find($permissionId);

    $this->permissionRepository->delete($role);

    return response()->json([], Response::HTTP_NO_CONTENT);
  }
}
