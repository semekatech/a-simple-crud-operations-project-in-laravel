<?php


namespace App\Http\Resources\Collections;

use App\Enums\ResponseType;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;

class BaseCollection extends ResourceCollection
{
    private $responseType;


    public function __construct($resource, $responseType = ResponseType::FULL)
    {
        parent::__construct($resource);
        $this->responseType = $responseType;
    }

    public function toArray($request)
    {
        if ($this->responseType == ResponseType::COMPACT) {
            $response = $this->toCompactResponse($request);
        } else if ($this->responseType == ResponseType::PAGINATED) {
            $response = $this->toPaginatedResponse($request);
        } else {
            $response = $this->toFullResponse($request);
        }
        return $response;

    }

    public function toFullResponse($request): array
    {
        return parent::toArray($request);
    }

    public function toCompactResponse($request): array
    {
        return $this->toFullResponse($request);
    }


    public function toPaginatedResponse($request): array
    {
        return [
            'data' => $this->getData($request),
            'pagination' => [
                'total' => $this->total(),
                'rowsNumber' => $this->total(),
                'rowsPerPage' => $this->perPage(),
                'page' => $request->input("pagination.page"),
                'total_pages' => $this->lastPage(),
                'from' => $this->firstItem(),
                'to' => $this->lastItem(),
                "sortBy" => $request->input("pagination.sortBy"),
                "descending" => $request->input("pagination.descending")
            ],
        ];
    }


    public function getData($request)
    {
        return $this->collection;
    }
}
