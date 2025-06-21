<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\Holiday\StoreHolidayRequest;
use App\Http\Requests\Holiday\UpdateHolidayRequest;

interface HolidayRepositoryInterface
{
    public function all(): array;
    public function find(int $id): array;
    public function create(StoreHolidayRequest $request): array;
    public function update(UpdateHolidayRequest $request, int $id): array;
    public function delete(int $id);
}
