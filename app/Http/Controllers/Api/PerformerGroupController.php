<?php

namespace App\Http\Controllers\Api;

use App\SuitEvent\Models\PerformerGroup;
use App\SuitEvent\Repositories\PerformerGroupRepository;
use App\SuitEvent\Repositories\PerformerGroupVoteRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Input;
use Response;
use Validator;

class PerformerGroupController extends BaseController
{
    /**
     * Initialize
     *
     * @param PerformerGroupRepository $repository
     * @param PerformerGroup           $model
     */
    public function __construct(
        PerformerGroupRepository $repository,
        PerformerGroup $model,
        PerformerGroupVoteRepository $groupVoteRepository
    ) {
        $this->groupVoteRepository = $groupVoteRepository;
        parent::__construct($repository, $model);
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
            'main_artist_id' => 'required|integer|exists:performer_candidates,id',
            'support_artist_id' => 'required|integer|exists:performer_candidates,id'
        ]);

        if ($validator->fails()) {
            return $this->toJson(400, [
                'message' => $validator->errors()->first()
            ]);
        }

        // check performer group
        $performerGroup = PerformerGroup::firstOrCreate([
                                            'performer_1_id' => $request->main_artist_id,
                                            'performer_2_id' => $request->support_artist_id
                                        ]);

        // Create vote record
        $params = [
            'performer_group_id' => $performerGroup->id,
            'votes' => 1
        ];

        $result = $this->groupVoteRepository->create($params);

        if ($result == false) {
            Session::flash('notif_error', 'Cannot save data to database, please double check your data!.');
            return redirect()->back();
        }

        // Update total votes of a candidate
        $groupVotes = $this->groupVoteRepository->getByParameter([
            'performer_group_id' => $performerGroup->id,
            'perPage' => -1
        ]);
        $performerGroup->total_vote = $groupVotes->sum('votes');
        $performerGroup->save();

        return $this->toJson(200, [
            'message' => 'Success submit vote',
            'result' => $performerGroup
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
}
