<?php

namespace App\Http\Controllers\Advertisements;

use App\Http\Requests\CreateAdvertisementRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAdvertisementRequest;
use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvertisementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
                ->only('createAdvertisement', 'deleteAdvertisement', 'updateAdvertisement');
    }
    public function index()
    {
        return Advertisement::all();
    }
    public function createAdvertisement(CreateAdvertisementRequest $request): JsonResponse
    {
        $data = $request->only([
            'title',
            'price',
            'isNegotiable',
            'description',
            'category_id',
            'state_id',
            'user_id'
        ]);
        $data['user_id'] = Auth::id();

        if(!array_key_exists('state_id', $data)) {
            $data['state_id'] = Auth::user()->state_id;
        }

        $newAdvertisement = Advertisement::create($data);

        if(!$newAdvertisement) {
            return response()->json([
               'error' => 'Advertisement not created, please try again or contact support'
            ], 500);
        }

        $response = [
            'title' => $newAdvertisement->title,
            'price' => $newAdvertisement->price,
            'description' => $newAdvertisement->description,
            'category_id' => $newAdvertisement->category->name,
            'state_id' => $newAdvertisement->state->name
        ];

        return response()->json($response);
    }
    public function deleteAdvertisement($id): JsonResponse
    {
        $advertisement = Advertisement::find($id);

        if(!$advertisement) {
            return response()->json([
               'error' => 'Advertisement not found'
            ], 400);
        }

        if($advertisement->user_id !== Auth::id()) {
            return response()->json([
               'error' => 'You cannot delete this advertisement'
            ], 400);
        }
        $advertisement->delete();

        return response()->json([
            'error' => ''
        ], 200);
    }
    public function updateAdvertisement(UpdateAdvertisementRequest $request, $id)
    {
        $advertisement = Advertisement::find($id);

        if(!$advertisement) {
            return response()->json([
               'error' => 'Advertisement not found'
            ], 400);
        }

        if($advertisement->user_id!== Auth::id()) {
            return response()->json([
               'error' => 'You cannot update this advertisement'
            ], 400);
        }

        $data = $request->only([
            'title',
            'price',
            'is_negotiable',
            'description',
            'category_id',
            'state_id',
            ]);

        $updatedFields = [];
        foreach ($data as $key => $value) {
            if ($value !== null && $value !== $advertisement->$key) {
                $advertisement->$key = $value;
                $updatedFields[] = $key;
            }
        }

        $updatedAdvertisement = $advertisement->save();

        if(!$updatedAdvertisement) {
            return response()->json([
               'error' => 'Advertisement not updated'
            ], 400);
        }

        $updatedFieldsMessage = [];
        foreach ($updatedFields as $field) {
            $updatedFieldsMessage[] = ucfirst($field) . " updated";
        }

        return response()->json([
            'error' => '',
            'updatedFields' => $updatedFieldsMessage,
        ]);

    }
    public function showAdvertisement($id)
    {
        $advertisement = Advertisement::find($id);
        if(!$advertisement) {
            return response()->json([
               'error' => 'Advertisement not found'
            ], 400);
        }

        $response = [
            'title' => $advertisement->title,
            'price' => $advertisement->price,
            'description' => $advertisement->description,
            'is_negotiable' => $advertisement->is_negotiable,
            'category_name' => $advertisement->category->name,
            'related_to' => $advertisement->user->name,
            'is_from' => $advertisement->state->name,
        ];
        return response()->json($response);
    }


}
