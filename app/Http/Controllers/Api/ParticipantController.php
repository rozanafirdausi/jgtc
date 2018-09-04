<?php

namespace App\Http\Controllers\Api;

use App\SuitEvent\Models\Participant;
use App\SuitEvent\Models\ParticipantAnswer;
use App\SuitEvent\Models\SurveyQuestion;
use App\SuitEvent\Repositories\GeneralInstanceRepository;
use App\SuitEvent\Repositories\ParticipantAnswerRepository;
use App\SuitEvent\Repositories\ParticipantRepository;
use DB;
use Illuminate\Http\Request;
use Input;
use Response;
use Validator;

class ParticipantController extends BaseController
{
    protected $participantAnswerRepository;
    protected $generalRepo;
    protected $defaultParams = [
        'orderBy' => 'position_order,name',
        'orderType' => 'asc'
    ];

    /**
     * Initialize
     *
     * @param ParticipantRepository $repository
     * @param Participant           $model
     */
    public function __construct(
        ParticipantRepository $repository,
        Participant $model,
        ParticipantAnswerRepository $participantAnswerRepository,
        GeneralInstanceRepository $generalRepo
    ) {
        $this->participantAnswerRepository = $participantAnswerRepository;
        $this->generalRepo = $generalRepo;
        parent::__construct($repository, $model);
    }

    /**
     * Post vote to performer candidate
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    protected function postVolunteerRegistration(Request $request)
    {
        // Input validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:64|unique:participants,email',
            'city' => 'required|integer|exists:kabkotas,id',
            'question1' => 'required|string',
            'question2' => 'required|string',
            'question3' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->toJson(400, [
                'message' => $validator->errors()->first()
            ]);
        }

        DB::beginTransaction();
        try {
            // Create participant record
            $params = [
                'type' => Participant::TYPE_VOLUNTEER,
                'name' => trim($request->name),
                'email' => trim($request->email),
                'phone' => null,
                'avatar' => null,
                'user_id' => null,
                'city_id' => $request->city,
                'position_order' => 0
            ];
            $result = $this->repository->create($params, $baseObject);

            if ($result == false) {
                return $this->toJson(400, [
                    'message' => 'Cannot save data to database, please double check your data!'
                ]);
            }

            // Add participant answer
            $numberOfQuestion = 3;
            for ($i = 1; $i <= $numberOfQuestion; $i++) {
                $answerRequestParam = 'question' . $i;
                $questionObject = SurveyQuestion::firstOrCreate([
                                                    'type' => SurveyQuestion::TYPE_VOLUNTEER,
                                                    'code' => 'VOLUNTEER0' . $i
                                                ]);
                $answerParams = [
                    'participant_id' => $result->id,
                    'user_id' => null,
                    'question_id' => $questionObject->id,
                    'answer_id' => null,
                    'text_type' => ParticipantAnswer::TEXTTYPE_TEXT,
                    'text' => trim($request->$answerRequestParam)
                ];

                $answer = $this->participantAnswerRepository->create($answerParams);

                if ($answer == false) {
                    return $this->toJson(400, [
                        'message' => 'Cannot save data to database, please double check your data!'
                    ]);
                }
            }
        } catch (\PDOException $e) {
            DB::rollback();
            info($e);
            return $this->toJson(500, [
                'message' => 'Cannot save data to database, please double check your data!'
            ]);
        }

        DB::commit();

        $cityId = $result->city ? $result->city->code : 0;
        $memberLink = $this->generalRepo->getVolunteerRegistrationLink(true, $result->email);
        $nonMemberLink = $this->generalRepo
        ->getVolunteerRegistrationLink(false, $result->email, $result->name, $cityId);
        $result->notify('ParticipantNew', $nonMemberLink, $result);

        // Add custom redirect link
        $resultArray = $result->toArray();
        $resultArray['member_link'] = $memberLink;
        $resultArray['non_member_link'] = $nonMemberLink;

        return $this->toJson(200, [
            'message' => 'Success submit volunteer registration',
            'result' => $resultArray
        ]);
    }

    /**
     * Post vote to performer candidate (version 2)
     * change log:
     * add question4 field
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    protected function postVolunteerRegistrationV2(Request $request)
    {
        // Input validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:64|unique:participants,email',
            'city' => 'required|integer|exists:kabkotas,id',
            'question1' => 'required|string',
            'question2' => 'required|string',
            'question3' => 'required|string',
            'question4' => 'required|string|in:lo,photographer,videographer'
        ]);

        if ($validator->fails()) {
            return $this->toJson(400, [
                'message' => $validator->errors()->first()
            ]);
        }

        DB::beginTransaction();
        try {
            // Create participant record
            $params = [
                'type' => Participant::TYPE_VOLUNTEER,
                'name' => trim($request->name),
                'email' => trim($request->email),
                'phone' => null,
                'avatar' => null,
                'user_id' => null,
                'city_id' => $request->city,
                'position_order' => 0
            ];
            $result = $this->repository->create($params, $baseObject);

            if ($result == false) {
                return $this->toJson(400, [
                    'message' => 'Cannot save data to database, please double check your data!'
                ]);
            }

            // Add participant answer
            $numberOfQuestion = 4;
            for ($i = 1; $i <= $numberOfQuestion; $i++) {
                $answerRequestParam = 'question' . $i;
                $questionObject = SurveyQuestion::firstOrCreate([
                                                    'type' => SurveyQuestion::TYPE_VOLUNTEER,
                                                    'code' => 'VOLUNTEER0' . $i
                                                ]);
                $answerParams = [
                    'participant_id' => $result->id,
                    'user_id' => null,
                    'question_id' => $questionObject->id,
                    'answer_id' => null,
                    'text_type' => ParticipantAnswer::TEXTTYPE_TEXT,
                    'text' => trim($request->$answerRequestParam)
                ];

                $answer = $this->participantAnswerRepository->create($answerParams);

                if ($answer == false) {
                    return $this->toJson(400, [
                        'message' => 'Cannot save data to database, please double check your data!'
                    ]);
                }
            }
        } catch (\PDOException $e) {
            DB::rollback();
            info($e);
            return $this->toJson(500, [
                'message' => 'Cannot save data to database, please double check your data!'
            ]);
        }

        DB::commit();

        $cityId = $result->city ? $result->city->code : 0;
        $memberLink = $this->generalRepo->getVolunteerRegistrationLink(true, $result->email);
        $nonMemberLink = $this->generalRepo
        ->getVolunteerRegistrationLink(false, $result->email, $result->name, $cityId);
        $result->notify('ParticipantNew', $nonMemberLink, $result);

        // Add custom redirect link
        $resultArray = $result->toArray();
        $resultArray['member_link'] = $memberLink;
        $resultArray['non_member_link'] = $nonMemberLink;

        return $this->toJson(200, [
            'message' => 'Success submit volunteer registration',
            'result' => $resultArray
        ]);
    }
}
