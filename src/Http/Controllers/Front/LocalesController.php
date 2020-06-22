<?php

namespace Vegacms\Cms\Http\Controllers\Front;

use Illuminate\Http\JsonResponse;
use Vegacms\Cms\Http\Controllers\Controller;
use Vegacms\Cms\Services\Interfaces\LocaleServiceInterface;
use Vegacms\Cms\Services\Interfaces\ValidationServiceInterface;

class LocalesController extends Controller
{
    /**
     * Set a site locale
     *
     * @param ValidationServiceInterface $validationService
     * @param LocaleServiceInterface $localeService
     * @return JsonResponse
     */
    public function setLocale(
        ValidationServiceInterface $validationService,
        LocaleServiceInterface $localeService
    ): JsonResponse {
        $validationData = $validationService->validate(request()->all(), ['code'], 'locale', 'set');

        if ($validationData === true) {
            $localeService->setSelectedLocale(request()->code);

            return response()->json(
                'The site locale is changed successfully.'
            );
        }

        return response()->json([
            'error' => $validationData
        ], 302);
    }
}
