<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auction\AuctionRequest;
use App\Http\Requests\Api\Auction\UpdateStatusAuctionRequest;
use App\Http\Resources\AuctionResource;
use App\Http\Resources\CommitAuctionResource;
use App\Http\Resources\MyAuctionResource;
use App\Http\Resources\UpdateStatusAuctionResource;
use App\Service\AuctionService;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    use HttpResponse;

    public function __construct(public AuctionService $auctionService)
    {}

    public function index()
    {
        $auctions = $this->auctionService->getAll();
        return $this->paginatedResponse($auctions, AuctionResource::class);

    }

    public function show($id)
    {
        $auction = $this->auctionService->getById($id);
        return $this->okResponse(new AuctionResource($auction), __('Commit Auction created successfully', [], request()->header('Accept-language')));

    }

    public function getMyAuction()
    {
        $auctions = $this->auctionService->getMyAuctions();
        return $this->paginatedResponse($auctions, MyAuctionResource::class);
    }

    public function commitAuction($id, AuctionRequest $request)
    {
        $auction = $this->auctionService->commitAuction($id, $request->validated());

        return $this->okResponse(new CommitAuctionResource($auction), __('Commit Auction created successfully', [], request()->header('Accept-language')));
    }

    public function UpdateStatusAuction($id, UpdateStatusAuctionRequest $request)
    {
        $auction = $this->auctionService->UpdateStatusAuction($id, $request->validated());
        return $this->okResponse(new UpdateStatusAuctionResource($auction), __('Commit Auction updated successfully', [], request()->header('Accept-language')));
    }

}
