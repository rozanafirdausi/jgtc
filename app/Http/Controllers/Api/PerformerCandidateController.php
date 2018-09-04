<?php

namespace App\Http\Controllers\Api;

use App\SuitEvent\Models\PerformerCandidate;
use App\SuitEvent\Models\PerformerGroup;
use App\SuitEvent\Repositories\PerformerCandidateRepository;
use App\SuitEvent\Repositories\PerformerCandidateVoteRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Input;
use Response;
use Validator;

class PerformerCandidateController extends BaseController
{
    protected $voteRepository;
    protected $defaultParams = [
        'orderBy' => 'position_order,name',
        'orderType' => 'asc'
    ];

    /**
     * Initialize
     *
     * @param PerformerCandidateRepository $repository
     * @param PerformerCandidate           $model
     */
    public function __construct(
        PerformerCandidateRepository $repository,
        PerformerCandidate $model,
        PerformerCandidateVoteRepository $voteRepository
    ) {
        $this->voteRepository = $voteRepository;
        parent::__construct($repository, $model);
    }

    /**
     * Get: Index Json (Array Json Data)
     *
     * @param  string $type
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getIndex($type = null)
    {
        if ($type == null || !array_key_exists($type, $this->baseModel->getTypeOptions())) {
            return $this->toJson(404, [
                'message' => 'The requested url is not found'
            ]);
        }

        $this->defaultParams['type'] = $type;
        $this->defaultParams['is_visible'] = PerformerCandidate::STATUS_VISIBLE;

        return parent::getIndex();
    }

    /**
     * Post vote to performer candidate
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    protected function postVote(Request $request)
    {
        // Input validation
        $validator = Validator::make($request->all(), [
            'candidate_id' => 'required|integer|exists:performer_candidates,id'
        ]);

        if ($validator->fails()) {
            return $this->toJson(400, [
                'message' => $validator->errors()->first()
            ]);
        }

        // Create vote record
        //$authenticatedUser = $this->getAccessTokenUser($request->get('token'));
        $params = [
            //'user_id' => $authenticatedUser ? $authenticatedUser->id : null,
            'candidate_id' => $request->candidate_id,
            'votes' => 1,
            'notes' => null
        ];
        $result = $this->voteRepository->create($params);

        if ($result == false) {
            return $this->toJson(400, [
                'message' => 'Cannot save data to database, please double check your data!'
            ]);
        }

        // Update total votes of a candidate
        $performerCandidate = $this->baseModel->find($request->candidate_id);
        $candidateVotes = $this->voteRepository->getByParameter([
            'candidate_id' => $request->candidate_id,
            'perPage' => -1
        ]);
        $performerCandidate->total_vote = $candidateVotes->sum('votes');
        $performerCandidate->save();

        return $this->toJson(200, [
            'message' => 'Success submit vote',
            'result' => $performerCandidate
        ]);
    }

    public function getVotePage()
    {
        $voteCountdownString = settings('performer_vote_deadline', '2017-10-17');
        $voteCountdown = Carbon::createFromTimeStamp(strtotime($voteCountdownString))->toIso8601String();
        return $this->toJson(200, [
            'message' => 'Success get performer vote page',
            'result' => [
                'performer-vote-deadline' => $voteCountdown
            ]
        ]);
    }

    public function getSupportingArtist($mainArtistId = null)
    {
        if ($mainArtistId) {
            $data = [];
            $performerGroups = PerformerGroup::where('performer_1_id', $mainArtistId)->get();
            if ($performerGroups) {
                foreach ($performerGroups as $group) {
                    $performer = PerformerCandidate::find($group->performer_2_id);
                    if ($performer) {
                        array_push($data, $performer);
                    }
                }
            }
            if (count($data) > 0) {
                $paginateData = new LengthAwarePaginator($data, count($data), 10);
                return $this->toJson(200, [
                    'message' => 'List of support artist retrieved!',
                    'result' => $paginateData,
                ]);
            } else {
                return $this->toJson(200, [
                    'message' => 'Empty list of support artist!',
                ]);
            }
        }

        $this->defaultParams['type'] = 'collab';
        $this->defaultParams['collab_type'] = 'support';
        $this->defaultParams['is_visible'] = PerformerCandidate::STATUS_VISIBLE;

        return parent::getIndex();
    }
}
